<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Api\Models\Recomendation;
use Api\Services\RecomendationService;


class RecomendationController
{
    private RecomendationService $recomendationService;

    public function __construct()
    {
        $recomendation = new Recomendation(\IBLOCK_ID_SETTINGS, \ELEMENT_ID_SETTINGS);
        $this->recomendationService = new RecomendationService($recomendation);
    }

    public function getRecomendation(Request $request, Response $response, $args)
    {

        $data = $this->recomendationService->getFormatted();

        $response->getBody()->write(json_encode(['recomendation' => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
