<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MicroserviceClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.microservice.url', 'http://localhost:3000');
    }

    /**
     * Check microservice health
     */
    public function checkHealth(): array
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/health");
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Microservice is healthy'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Microservice health check failed',
                'status_code' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Microservice health check failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Unable to connect to microservice',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get services from microservice
     */
    public function getServices(): array
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/services");
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Services retrieved successfully'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Failed to retrieve services',
                'status_code' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get services from microservice: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Unable to connect to microservice',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Validate user through microservice
     */
    public function validateUser(string $email): array
    {
        try {
            $response = Http::timeout(5)->post("{$this->baseUrl}/validate-user", [
                'email' => $email
            ]);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'User validation completed'
                ];
            }
            
            return [
                'success' => false,
                'message' => 'User validation failed',
                'status_code' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('User validation failed: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Unable to validate user through microservice',
                'error' => $e->getMessage()
            ];
        }
    }
}
