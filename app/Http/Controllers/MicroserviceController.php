<?php

namespace App\Http\Controllers;

use App\Services\MicroserviceClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MicroserviceController extends Controller
{
    protected MicroserviceClient $microserviceClient;

    public function __construct(MicroserviceClient $microserviceClient)
    {
        $this->microserviceClient = $microserviceClient;
    }

    /**
     * Check microservice health
     */
    public function checkMicroserviceHealth(): JsonResponse
    {
        $result = $this->microserviceClient->checkHealth();
        
        return response()->json($result, $result['success'] ? 200 : 503);
    }

    /**
     * Get services from microservice
     */
    public function getServices(): JsonResponse
    {
        $result = $this->microserviceClient->getServices();
        
        return response()->json($result, $result['success'] ? 200 : 503);
    }

    /**
     * Validate user through microservice
     */
    public function validateUser(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $result = $this->microserviceClient->validateUser($request->email);
        
        return response()->json($result, $result['success'] ? 200 : 503);
    }
}
