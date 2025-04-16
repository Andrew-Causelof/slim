<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Patient;
use Api\Traits\ResponseTrait;
use Bitrix\Main\UserTable;
use \Seogravity\User\PatientHLService;

class PatientController
{
    use ResponseTrait;

    public function getProfile(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if (!$id) {
            $response->getBody()->write(json_encode(['error' => 'ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $patient = Patient::find($id);

        if (!$patient) { // если нет записи в таблице хайлоадблока

            $user = UserTable::getById($id)->fetch();

            if (!$user) {
                $response->getBody()->write(json_encode(['error' => 'Patient not found']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }

            (new PatientHLService())->updateHLFromUser($id); // создаем запись из пользовательских полей
            $patient = Patient::find($id);
        }

        // Декодируем поле UF_USER_DATA, чтобы вернуть его как JSON
        $userData = json_decode($patient['UF_USER_DATA'], true);

        // Проверяем, успешно ли декодировалось
        if (json_last_error() !== JSON_ERROR_NONE) {
            $response->getBody()->write(json_encode(['error' => 'Invalid JSON in UF_USER_DATA']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

        $response->getBody()->write(json_encode($userData));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function updateProfile(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if (!$id) {
            $response->getBody()->write(json_encode(['error' => 'ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Получаем "сырое" тело запроса
        $rawBody = $request->getBody()->getContents();

        // Декодируем JSON вручную
        $data = json_decode($rawBody, true);

        // Проверяем, был ли JSON успешно распарсен
        if (json_last_error() !== JSON_ERROR_NONE) {
            $response->getBody()->write(json_encode(['error' => 'Invalid JSON']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        if (empty($data)) {
            $response->getBody()->write(json_encode(['error' => 'Empty request body']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }


        $patient = Patient::find($id);

        if (!$patient) {
            $response->getBody()->write(json_encode(['error' => 'Patient not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $patientID = $patient['ID']; // Получаем ID пациента в Таблице HLBlockTable
        $result = Patient::update($patientID, $request->getBody()->getContents());

        if (!$result) {
            $response->getBody()->write(json_encode(['error' => 'Patient not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write(json_encode(['message' => 'Patient updated successfully']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function updateOperations(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if (!$id) {
            return $this->withCors($response, ['error' => 'ID is required'], 400);
        }

        // Находим пациента
        $patient = Patient::find($id);

        if (!$patient) {
            return $this->withCors($response, ['error' => 'Patient not found'], 404);
        }

        // Загружаем текущие данные пациента
        $currentData = json_decode($patient['UF_USER_DATA'], true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($currentData)) {
            return $this->withCors($response, ['error' => 'Invalid JSON in UF_USER_DATA'], 500);
        }

        // Читаем новые операции из запроса
        $rawBody = $request->getBody()->getContents();
        $newOperations = json_decode($rawBody, true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($newOperations)) {
            return $this->withCors($response, ['error' => 'Invalid or empty JSON'], 400);
        }

        // 🔥 Обновляем только поле "operations" внутри существующих данных
        $currentData['operations'] = $newOperations;

        // Сохраняем обновлённый JSON обратно
        $result = Patient::update($patient['ID'], $currentData);

        if (!$result) {
            return $this->withCors($response, ['error' => 'Failed to update patient data'], 500);
        }

        return $this->withCors($response, ['message' => 'Operations updated successfully'], 200);
    }



    // Функция для установки заголовков CORS
    private function withCors(Response $response, array $data, int $status = 200)
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->withStatus($status);
    }
}
