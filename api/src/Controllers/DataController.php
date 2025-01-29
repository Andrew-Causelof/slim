<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Data;

class DataController
{
    public function getRegion(Request $request, Response $response, $args)
    {
        $user = Data::find('region');
        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getById(Request $request, Response $response, array $args)
    {

        $id = $args['id'] ?? null;

        if (!$id) {
            $response->getBody()->write(json_encode(['error' => 'ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Например, загружаем данные по ID (это просто пример, заменить на свою логику)
        $data = Data::find($id);

        // Возвращаем JSON-ответ
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
