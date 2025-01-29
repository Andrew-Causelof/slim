<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\Document;

class DocumentController
{
    public function getList(Request $request, Response $response, $args)
    {
        // Создаём список документов
        $documents = [
            new Document(1, 1, 'Анализ крови', '2025-01-20', '/documents/blood_test.pdf'),
            new Document(2, 1, 'Рентген грудной клетки', '2025-01-22', '/documents/chest_xray.pdf')
        ];

        $response->getBody()->write(json_encode($documents));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
