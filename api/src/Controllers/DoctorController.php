<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Doctor;

class DoctorController
{
    public function getProfile(Request $request, Response $response, $args)
    {
        $userId = $request->getQueryParams()['userId'] ?? null;

        if (!$userId) {
            $response->getBody()->write(json_encode(['error' => 'User ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Создаём объект доктора
        $doctor = new Doctor($userId, 'Дмитрий Петров', 'Кардиолог', 'd.petrov@example.com');

        $response->getBody()->write(json_encode($doctor));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
