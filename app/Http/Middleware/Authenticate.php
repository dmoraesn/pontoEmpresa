<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redireciona o usuário para login se não estiver autenticado.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('login'); // 👈 garante que sempre vá pro login
        }

        return null;
    }
}
