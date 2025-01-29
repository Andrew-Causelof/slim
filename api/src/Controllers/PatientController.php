<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Patient;

class PatientController
{
    public function getProfile(Request $request, Response $response, $args)
    {
        $userId = $request->getQueryParams()['userId'] ?? null;

        if (!$userId) {
            $response->getBody()->write(json_encode(['error' => 'User ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Создаём объект пациента
        $patient = new Patient($userId, 'Иван Иванов', 30, 'ivan.ivanov@example.com');

        $response->getBody()->write(json_encode($patient));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
