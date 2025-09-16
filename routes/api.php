<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UsuarioController;
use App\Http\Controllers\Web\MarcacaoController;
use App\Http\Controllers\Web\AbonoController;
use App\Http\Controllers\Web\HorarioController;
use App\Http\Controllers\Web\FeriadoController;
use App\Http\Controllers\Web\RhController;

// Usuários
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/{id}/espelho', [UsuarioController::class, 'espelho']);

// Marcações
Route::get('/usuarios/{id}/marcacoes', [MarcacaoController::class, 'index']);
Route::post('/usuarios/{id}/marcacoes', [MarcacaoController::class, 'store']);
Route::put('/marcacoes/{id}', [MarcacaoController::class, 'update']);

// Abonos
Route::get('/usuarios/{id}/abonos', [AbonoController::class, 'index']);
Route::post('/usuarios/{id}/abonos', [AbonoController::class, 'store']);

// Horários
Route::get('/horarios', [HorarioController::class, 'index']);
Route::post('/horarios', [HorarioController::class, 'store']);

// Feriados
Route::get('/feriados', [FeriadoController::class, 'index']);
Route::post('/feriados', [FeriadoController::class, 'store']);

// Dashboard RH
Route::get('/rh/dashboard', [RhController::class, 'index']);
