<?php

use App\Http\Controllers\PublicQRCodeController;
use App\Http\Controllers\Web\AfastamentoController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\UsuarioController;
use App\Http\Controllers\Web\MarcacaoController;
use App\Http\Controllers\Web\AbonoController;
use App\Http\Controllers\Web\HorarioController;
use App\Http\Controllers\Web\FeriadoController;
use App\Http\Controllers\Web\FeriasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROTAS DE AUTENTICAÇÃO ---
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Usuário ou senha incorretos.',
    ]);
})->name('login.auth');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// --- GRUPO DE ROTAS PROTEGIDAS POR AUTENTICAÇÃO ---
Route::middleware(['auth'])->group(function () {

    // --- ROTA PRINCIPAL ---
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-marcacao', [MarcacaoController::class, 'updateFromDashboard'])
        ->name('dashboard.update-marcacao');

    // --- GRUPO DE ROTAS CENTRADAS NO USUÁRIO ---
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::resource('/', UsuarioController::class)->parameters(['' => 'usuario']);

        Route::get('/{usuario}/espelho', [UsuarioController::class, 'espelho'])->name('espelho');
        Route::get('/{usuario}/espelho/pdf', [UsuarioController::class, 'gerarEspelhoPDF'])->name('espelho.pdf');

        Route::prefix('{usuario}/ponto')->name('ponto.')->group(function () {
            Route::get('/', [MarcacaoController::class, 'index'])->name('index');
            Route::post('/', [MarcacaoController::class, 'store'])->name('store');
            Route::get('/{marcacao}/edit', [MarcacaoController::class, 'edit'])->name('edit');
            Route::put('/{marcacao}', [MarcacaoController::class, 'update'])->name('update');
            Route::delete('/{marcacao}', [MarcacaoController::class, 'destroy'])->name('destroy');
        });

        Route::get('/{usuario}/abonos', [AbonoController::class, 'index'])->name('abonos.index');
        Route::post('/{usuario}/abonos', [AbonoController::class, 'store'])->name('abonos.store');
        Route::delete('/{usuario}/abonos/{abono}', [AbonoController::class, 'destroy'])->name('abonos.destroy');

        Route::get('/{usuario}/ferias', [FeriasController::class, 'index'])->name('ferias.index');
        Route::post('/{usuario}/ferias', [FeriasController::class, 'store'])->name('ferias.store');
        Route::delete('/{usuario}/ferias/{ferias}', [FeriasController::class, 'destroy'])->name('ferias.destroy');
    });

    // --- ROTAS DE RECURSOS GLOBAIS ---
    Route::resource('horarios', HorarioController::class);
    Route::resource('feriados', FeriadoController::class);

    Route::post('/marcacoes/ajuste-rapido', [MarcacaoController::class, 'ajusteRapido'])->name('marcacoes.ajusteRapido');

    Route::resource('afastamentos', AfastamentoController::class);
});

// --- PÁGINAS PÚBLICAS (fora do auth) ---
Route::get('/registro-publico', function () {
    return view('public.presenca');
});

Route::get('/qrcode', [PublicQRCodeController::class, 'show'])->name('qrcode.public');
