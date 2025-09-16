<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\UsuarioController;
use App\Http\Controllers\Web\MarcacaoController;
use App\Http\Controllers\Web\AbonoController;
use App\Http\Controllers\Web\HorarioController;
use App\Http\Controllers\Web\FeriadoController;
use App\Http\Controllers\Web\FeriasController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Web\LeituraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROTA PRINCIPAL ---
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard/update-marcacao', [MarcacaoController::class, 'updateFromDashboard'])
    ->name('dashboard.update-marcacao');

// --- GRUPO DE ROTAS CENTRADAS NO USUÁRIO ---
Route::prefix('usuarios')->name('usuarios.')->group(function () {

    // CRUD de Usuários (usando resource)
    Route::resource('/', UsuarioController::class)->parameters(['' => 'usuario']);

    // Espelho de ponto do usuário
    Route::get('/{usuario}/espelho', [UsuarioController::class, 'espelho'])->name('espelho');
    Route::get('/{usuario}/espelho/pdf', [UsuarioController::class, 'gerarEspelhoPDF'])->name('espelho.pdf');

    // Marcações de ponto (nested resource)
    Route::prefix('{usuario}/ponto')->name('ponto.')->group(function () {
        Route::get('/', [MarcacaoController::class, 'index'])->name('index');
        Route::post('/', [MarcacaoController::class, 'store'])->name('store');
        Route::get('/{marcacao}/edit', [MarcacaoController::class, 'edit'])->name('edit');
        Route::put('/{marcacao}', [MarcacaoController::class, 'update'])->name('update');
        Route::delete('/{marcacao}', [MarcacaoController::class, 'destroy'])->name('destroy');
    });

    // Abonos
    Route::get('/{usuario}/abonos', [AbonoController::class, 'index'])->name('abonos.index');
    Route::post('/{usuario}/abonos', [AbonoController::class, 'store'])->name('abonos.store');
    Route::delete('/{usuario}/abonos/{abono}', [AbonoController::class, 'destroy'])->name('abonos.destroy');

    // Férias
    Route::get('/{usuario}/ferias', [FeriasController::class, 'index'])->name('ferias.index');
    Route::post('/{usuario}/ferias', [FeriasController::class, 'store'])->name('ferias.store');
    Route::delete('/{usuario}/ferias/{ferias}', [FeriasController::class, 'destroy'])->name('ferias.destroy');
});

// --- ROTAS DE RECURSOS GLOBAIS ---
Route::resource('horarios', HorarioController::class);
Route::resource('feriados', FeriadoController::class);

// --- AJAX de marcações ---
Route::post('/marcacoes/ajuste-rapido', [MarcacaoController::class, 'ajusteRapido'])->name('marcacoes.ajusteRapido');

// --- PÁGINA PÚBLICA DE REGISTRO ---
Route::get('/registro-publico', function () {
    return view('public.presenca');
});

// --- LEITURA (PÚBLICA ou VIA CELULAR) ---
Route::get('/leitura', [LoginController::class, 'form'])->name('leitura.form');
Route::post('/leitura', [LoginController::class, 'auth'])->name('leitura.auth');

Route::get('/leitura/scan', [LeituraController::class, 'scan'])->name('leitura.scan');
Route::post('/leitura/registrar', [LeituraController::class, 'registrar'])->name('leitura.registrar');



Route::get('/leitura', [LoginController::class, 'form'])->name('leitura.form');
Route::post('/leitura', [LoginController::class, 'auth'])->name('leitura.auth');

Route::get('/leitura/scan', [LeituraController::class, 'scan'])->name('leitura.scan');
Route::post('/leitura/registrar', [LeituraController::class, 'registrar'])->name('leitura.registrar');



Route::get('/leitura/scan', [LeituraController::class, 'scan'])->name('leitura.scan');
Route::post('/leitura/registrar', [LeituraController::class, 'registrar'])->name('leitura.registrar');




Route::get('/leitura', [LeituraController::class, 'form'])->name('leitura.form');
Route::post('/leitura/login', [LeituraController::class, 'login'])->name('leitura.login');
Route::get('/leitura/scan', [LeituraController::class, 'scan'])->name('leitura.scan');
Route::post('/leitura/registrar', [LeituraController::class, 'registrar'])->name('leitura.registrar');
Route::get('/leitura/gerar-token', [LeituraController::class, 'gerarToken'])->name('leitura.gerar.token');



// QR público (pode ser acessado sem login)
Route::get('/leitura', [LeituraController::class, 'form'])->name('leitura.form');

// Scanner (requer login para funcionar)
Route::middleware('auth')->group(function () {
    Route::get('/leitura/scan', [LeituraController::class, 'scan'])->name('leitura.scan');
    Route::post('/leitura/registrar', [LeituraController::class, 'registrar'])->name('leitura.registrar');
});
