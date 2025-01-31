<?php

use Slim\Factory\AppFactory;
use Api\Controllers\UserController;
use Api\Controllers\PatientController;
use Api\Controllers\DoctorController;
use Api\Controllers\AppointmentController;
use Api\Controllers\DocumentController;
use Api\Controllers\DataController;

require __DIR__ . '/../../local/vendor/autoload.php';

// Подключение ядра Bitrix
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$app = AppFactory::create();


// Маршруты для пациента
$app->get('/api/patient/{id:[0-9]+}', [PatientController::class, 'getProfile']);
$app->get('/api/patient/data', [DataController::class, 'getDatas']);

$app->put('/api/patient/{id:[0-9]+}', [PatientController::class, 'updateProfile']);

// Маршруты для данных
$app->get('/api/data/{id:[0-9]+}', [DataController::class, 'getById']);


$app->run();
