<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\PatientService;
use Api\Traits\ResponseTrait;

class PatientsController
{
    use ResponseTrait;

    private PatientService $patientService;

    public function __construct()
    {
        $this->patientService = new PatientService();
    }

    public function getPatients(Request $request, Response $response)
    {
        $queryParams = $request->getQueryParams();

        $page = isset($queryParams['page']) ? (int) $queryParams['page'] : 1;
        $limit = isset($queryParams['limit']) ? (int) $queryParams['limit'] : 20;
        $letter = isset($queryParams['letter']) ? trim($queryParams['letter']) : '';

        $patients = $this->patientService->getPatients($page, $limit, $letter);
        $total = $this->patientService->countPatients($letter);
        $letters = $this->patientService->getAvailableLetters();

        $data = [
            'patients' => $patients,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'pages' => ceil($total / $limit),
            ],
            'letters' => $letters,
        ];

        return $this->successResponse($response, $data);
    }
}
