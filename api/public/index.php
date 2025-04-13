<?php

use Slim\Factory\AppFactory;
use Api\Controllers\UserController;
use Api\Controllers\PatientController;
use Api\Controllers\DoctorController;
use Api\Controllers\AppointmentController;
use Api\Controllers\DocumentController;
use Api\Controllers\DataController;
use Api\Controllers\RulesController;
use Api\Controllers\RecomendationController;
use Api\Controllers\PatientsController;

// Подключение ядра Bitrix
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

// === 1. CORS Middleware (перемещено в начало) ===
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    $origin = $request->getHeaderLine('Origin');

    if (!empty($origin)) {
        $response = $response
            ->withHeader('Access-Control-Allow-Origin', $origin) // Разрешить конкретный Origin
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->withHeader('Access-Control-Allow-Credentials', 'true'); // Должно быть `true`, если используется `withCredentials`
    }

    return $response;
});

// === 2. Обработчик OPTIONS ===
$app->options('/{routes:.+}', function ($request, $response, $args) {
    $origin = $request->getHeaderLine('Origin');

    if (!empty($origin)) {
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withStatus(200);
    }

    return $response->withStatus(403);
});



// === 3. Маршруты ===
// Маршруты для пациента
$app->get('/api/patient/{id:[0-9]+}', [PatientController::class, 'getProfile']);
$app->get('/api/patient/data', [DataController::class, 'getDatas']);

$app->put('/api/patient/{id:[0-9]+}', [PatientController::class, 'updateProfile']);

// Маршруты для пациентов (страница со списком пациентов) ?page=2&limit=5&letter=Б
$app->get('/api/patients', [PatientsController::class, 'getPatients']);




// Маршруты для данных
$app->get('/api/data/{id:[0-9]+}', [DataController::class, 'getById']);

// Работа с файлами 
$app->post('/api/patient/{id}/files/upload',  [DocumentController::class, 'uploadFile']);
$app->delete('/api/patient/{id}/files/{fileId}', [DocumentController::class, 'deleteFile']);
//$app->get('/api/patient/{id}/files', [DocumentController::class, 'getFiles']);

// Правила госпиталзации
$app->get('/api/rules', [RulesController::class, 'getRules']);

// Рекомендации после операции
$app->get('/api/recomendation', [RecomendationController::class, 'getRecomendation']);

// Авторизация
$app->post('/api/user/login', [UserController::class, 'login']);
$app->post('/api/user/logout', [UserController::class, 'logout']); // @TODO реализовать по необходимости
$app->post('/api/user/restore', [UserController::class, 'restore']);

$app->run();
