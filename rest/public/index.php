<?php

use Slim\Factory\AppFactory;
use Rest\Controllers\UserController;

require __DIR__ . '/../../local/vendor/autoload.php';

$app = AppFactory::create();

// Добавляем маршруты
$app->get('/rest/slcrm.api.user.getProfile', [UserController::class, 'getProfile']);

$app->run();
