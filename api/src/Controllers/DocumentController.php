<?php

namespace Api\Controllers;

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Document;
use Api\Traits\ResponseTrait;

class DocumentController
{

    use ResponseTrait;

    // Загрузка файла
    public function uploadFile(Request $request, Response $response, $args)
    {
        if (!Loader::includeModule("main")) {
            return $this->errorResponse($response, "Не удалось подключить модуль main", 500);
        }

        $id = $args['id'] ?? null;

        if (!$id) {
            return $this->errorResponse($response, "ID is required", 400);
        }

        $uploadedFiles = $request->getUploadedFiles();

        if (empty($uploadedFiles['file'])) {
            return $this->errorResponse($response, "Файл не загружен", 400);
        }

        $file = $uploadedFiles['file'];

        // Подготавливаем файл для загрузки в Битрикс
        $fileArray = [
            "name" => $file->getClientFilename(),
            "size" => $file->getSize(),
            "tmp_name" => $file->getStream()->getMetadata('uri'),
            "type" => $file->getClientMediaType(),
            "MODULE_ID" => "main"
        ];

        // Загружаем файл в Битрикс
        $fileId = \CFile::SaveFile($fileArray, "patient_documents");

        if (!$fileId) {
            return $this->errorResponse($response, "Ошибка сохранения файла", 500);
        }

        // Получаем информацию о файле
        $fileInfo = \CFile::GetFileArray($fileId);

        // Формируем ответ
        $fileData = [
            "id" => $fileId,
            "name" => $fileInfo['ORIGINAL_NAME'],
            "path" => $fileInfo['SRC'],
            "full_path" => $_SERVER["DOCUMENT_ROOT"] . $fileInfo['SRC'],
            "size" => $fileInfo["FILE_SIZE"]
        ];

        //@TODO - сохранить в профиле пользователя и обновить данные в HLB
        // 1) Обновить данные пользователя в таблице HLB
        // 2) Обновить данные пользователя

        $response->getBody()->write(json_encode($fileData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    // Удаление файла
    public function deleteFile(Request $request, Response $response, $args)
    {
        if (!Loader::includeModule("main")) {
            return $this->errorResponse($response, "Не удалось подключить модуль main", 500);
        }

        $userId = $args['id'] ?? null;
        $fileId = $args['fileId'] ?? null;

        if (!$userId || !$fileId) {
            return $this->errorResponse($response, "ID пользователя и файла обязательны", 400);
        }

        // Проверяем, существует ли файл
        $fileInfo = \CFile::GetFileArray($fileId);
        if (!$fileInfo) {
            return $this->errorResponse($response, "Файл не найден", 404);
        }

        \CFile::Delete($fileId);

        if (!\CFile::GetByID($fileId)->Fetch()) {
            return $this->successResponse($response, "Файл успешно удален");
        }

        return $this->errorResponse($response, "Ошибка удаления файла", 500);
    }
}
