<?php

namespace Square\Http\Controllers;

use Square\Services\LogService;
use Response;

class LogController extends Controller
{
    private $logService;

    function __construct(LogService $service)
    {
        $this->logService = $service;
    }

    public function listLog($limit){
        $logs = $this->logService->listLog($limit);

        return Response::json([
            'error' => false,
            'data' => $logs,
        ], 200);

    }
}
