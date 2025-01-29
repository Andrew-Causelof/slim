<?php

use Slim\Factory\AppFactory;
use Api\Controllers\UserController;
use Api\Controllers\PatientController;
use Api\Controllers\DoctorController;
use Api\Controllers\AppointmentController;
use Api\Controllers\DocumentController;
use Api\Controllers\DataController;

require __DIR__ . '/../../local/vendor/autoload.php';

$app = AppFactory::create();

// Добавляем маршруты
$app->get('/api/user/profile', [UserController::class, 'getProfile']);

// Маршруты для пациента
$app->get('/api/patient/profile', [PatientController::class, 'getProfile']);

// Маршруты для доктора
$app->get('/api/doctor/profile', [DoctorController::class, 'getProfile']);

// Маршруты для данных
$app->get('/api/data/{id:[0-9]+}', [DataController::class, 'getById']);
$app->get('/api/data/regions', [DataController::class, 'getRegion']);

// Маршруты для приёмов
$app->get('/api/appointments', [AppointmentController::class, 'getList']);

// Маршруты для документов
$app->get('/api/documents', [DocumentController::class, 'getList']);

$app->run();
