<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MicroserviceClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.microservice.url', 'http://localhost:3000');
    }

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


    public function validateUser(string $email): array
    {
        // Criar uma chave de cache única baseada no email
        $cacheKey = "user_validation:" . md5($email);
        
        // Verificar se existe no cache (TTL de 15 minutos)
        $cachedResult = Cache::store('redis')->get($cacheKey);
        
        if ($cachedResult !== null) {
            Log::info('User validation retrieved from cache', ['email' => $email]);
            return $cachedResult;
        }
        
        try {
            $response = Http::timeout(5)->post("{$this->baseUrl}/validate-user", [
                'email' => $email
            ]);
            
            if ($response->successful()) {
                $result = [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'User validation completed'
                ];
                
                // Armazenar no cache por 15 minutos (900 segundos)
                Cache::store('redis')->put($cacheKey, $result, 900);
                
                Log::info('User validation completed and cached', ['email' => $email]);
                
                return $result;
            }
            
            $result = [
                'success' => false,
                'message' => 'User validation failed',
                'status_code' => $response->status()
            ];
            
            // Cache negative results for a shorter time (5 minutes)
            Cache::store('redis')->put($cacheKey, $result, 300);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('User validation failed: ' . $e->getMessage());
            
            $result = [
                'success' => false,
                'message' => 'Unable to validate user through microservice',
                'error' => $e->getMessage()
            ];
            
            // Cache error results for a very short time (1 minute)
            Cache::store('redis')->put($cacheKey, $result, 60);
            
            return $result;
        }
    }

    /**
     * Clear user validation cache
     */
    public function clearUserValidationCache(string $email): bool
    {
        $cacheKey = "user_validation:" . md5($email);
        
        $result = Cache::store('redis')->forget($cacheKey);
        
        if ($result) {
            Log::info('User validation cache cleared', ['email' => $email]);
        }
        
        return $result;
    }

    /**
     * Clear all user validation cache
     */
    public function clearAllUserValidationCache(): bool
    {
        try {
            // Get Redis connection
            $redis = Cache::store('redis')->getRedis();
            
            // Get all keys matching the pattern
            $keys = $redis->keys('*user_validation:*');
            
            if (!empty($keys)) {
                $redis->del($keys);
                Log::info('All user validation cache cleared', ['keys_count' => count($keys)]);
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to clear all user validation cache: ' . $e->getMessage());
            return false;
        }
    }
}
