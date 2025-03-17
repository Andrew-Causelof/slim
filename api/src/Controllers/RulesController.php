<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Api\Models\Rules;
use Api\Services\RulesService;

class RulesController
{
    private RulesService $rulesService;

    public function __construct()
    {
        $rulesModel = new Rules(IBLOCK_ID_SETTINGS, ELEMENT_ID_SETTINGS);
        $this->rulesService = new RulesService($rulesModel);
    }

    public function getRules(Request $request, Response $response, $args)
    {
        $data = $this->rulesService->getFormattedRules();

        $response->getBody()->write(json_encode(['rules' => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
