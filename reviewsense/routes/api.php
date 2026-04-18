<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Auth publique
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Reviews CRUD
    Route::apiResource('reviews', ReviewController::class);

    // Analyse IA manuelle
    Route::post('/analyze', [ReviewController::class, 'analyze']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
});