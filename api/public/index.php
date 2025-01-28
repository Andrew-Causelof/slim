<?php

use Slim\Factory\AppFactory;
use Api\Controllers\UserController;

require __DIR__ . '/../../local/vendor/autoload.php';

$app = AppFactory::create();

// Добавляем маршруты
$app->get('/api/user/profile', [UserController::class, 'getProfile']);

$app->run();
