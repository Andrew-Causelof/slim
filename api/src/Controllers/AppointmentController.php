<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Appointment;

class AppointmentController
{
    public function getList(Request $request, Response $response, $args)
    {
        // Создаём список приёмов
        $appointments = [
            new Appointment(1, 1, 1, '2025-02-15', '10:00', 'Запланировано'),
            new Appointment(2, 2, 1, '2025-02-16', '11:00', 'Завершено')
        ];

        $response->getBody()->write(json_encode($appointments));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
