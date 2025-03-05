<?php

namespace Api\Traits;

use Psr\Http\Message\ResponseInterface as Response;

trait ResponseTrait
{
    /**
     * Возвращает успешный JSON-ответ
     */
    private function successResponse(Response $response, $message, $data = [])
    {
        $payload = ['success' => $message];

        if (!empty($data)) {
            $payload['data'] = $data;
        }

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    /**
     * Возвращает JSON-ошибку
     */
    private function errorResponse(Response $response, $message, $statusCode)
    {
        $response->getBody()->write(json_encode(['error' => $message], JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
    }
}
