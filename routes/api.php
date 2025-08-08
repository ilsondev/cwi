<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\MicroserviceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Health check endpoint
Route::get('/health', [HealthController::class, 'health']);

// User CRUD routes
Route::apiResource('users', UserController::class);

// Microservice integration routes
Route::prefix('microservice')->group(function () {
    Route::get('/health', [MicroserviceController::class, 'checkMicroserviceHealth']);
    Route::get('/services', [MicroserviceController::class, 'getServices']);
    Route::post('/validate-user', [MicroserviceController::class, 'validateUser']);
});
