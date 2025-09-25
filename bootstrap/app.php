<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 🔑 Registrando os middlewares
        $middleware->alias([
            'auth'       => \App\Http\Middleware\Authenticate::class,
            'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'check.tipo' => \App\Http\Middleware\CheckTipoUsuario::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
