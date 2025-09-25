<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PontoController;

// 🔐 Rotas públicas (sem autenticação)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔒 Rotas protegidas por Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Dados do usuário logado
    Route::get('/user', [AuthController::class, 'user']);

    // Marcação de ponto
    Route::post('/bater-ponto', [PontoController::class, 'bater']);
});
