<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Models\User;

class UserController
{
    public function getProfile(Request $request, Response $response, $args)
    {
        $userId = $request->getQueryParams()['userId'] ?? null;

        if (!$userId) {
            $response->getBody()->write(json_encode(['error' => 'User ID is required']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $user = User::find($userId);
        if (!$user) {
            $response->getBody()->write(json_encode(['error' => 'User not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
