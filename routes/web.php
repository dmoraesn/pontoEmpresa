<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicQRCodeController;
use App\Http\Controllers\Web\AfastamentoController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\UsuarioController;
use App\Http\Controllers\Web\MarcacaoController;
use App\Http\Controllers\Web\AbonoController;
use App\Http\Controllers\Web\HorarioController;
use App\Http\Controllers\Web\FeriadoController;
use App\Http\Controllers\Web\FeriasController;
use App\Http\Controllers\PontoController;

/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
| Aqui ficam todas as rotas da aplicação
|--------------------------------------------------------------------------
*/

/**
 * ROTAS DE LOGIN / LOGOUT
 */
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'form'])->name('login');
    Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


/**
 * ROTAS ADMINISTRATIVAS (somente admin)
 */
Route::middleware(['auth', 'check.tipo:admin'])->group(function () {

    // Dashboard (rota raiz do admin)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/dashboard/update-marcacao', [MarcacaoController::class, 'updateFromDashboard'])
        ->name('dashboard.update-marcacao');

    // Usuários
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::resource('/', UsuarioController::class)->parameters(['' => 'usuario']);
        Route::get('/{usuario}/espelho', [UsuarioController::class, 'espelho'])->name('espelho');
        Route::get('/{usuario}/espelho/pdf', [UsuarioController::class, 'gerarEspelhoPDF'])->name('espelho.pdf');

        Route::prefix('{usuario}')->group(function () {
            Route::resource('ponto', MarcacaoController::class);
            Route::resource('abonos', AbonoController::class)->only(['index', 'store', 'destroy']);
            Route::resource('ferias', FeriasController::class)->only(['index', 'store', 'destroy']);
        });
    });

    // Recursos globais
    Route::resources([
        'horarios'     => HorarioController::class,
        'feriados'     => FeriadoController::class,
        'afastamentos' => AfastamentoController::class,
    ]);

    Route::post('/marcacoes/ajuste-rapido', [MarcacaoController::class, 'ajusteRapido'])
        ->name('marcacoes.ajusteRapido');
});


/**
 * ROTAS FUNCIONÁRIOS
 */
Route::middleware(['auth', 'check.tipo:funcionario'])
    ->prefix('funcionario')
    ->name('funcionario.')
    ->group(function () {
        Route::get('/ponto', [PontoController::class, 'index'])->name('ponto');
        Route::post('/ponto/marcar', [PontoController::class, 'marcar'])->name('marcar');
        Route::get('/historico', [PontoController::class, 'historico'])->name('historico');
    });


/**
 * PÁGINAS PÚBLICAS
 */
Route::view('/registro-publico', 'public.presenca')->name('registro.publico');
Route::get('/qrcode', [PublicQRCodeController::class, 'show'])->name('qrcode.public');
