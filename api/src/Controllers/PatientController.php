<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Patient;

class PatientController
{
    public function getProfile(Request $request, Response $response, $args)
    {
        $id = $args['id'] ?? null;

        if (!$id) {
            $response->getBody()->write(json_encode(['error' => 'ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $patient = Patient::find($id);

        if (!$patient) {
            $response->getBody()->write(json_encode(['error' => 'Patient not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
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
