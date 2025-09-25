<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // ✅ Redireciona de acordo com o tipo do usuário
                if ($user->tipo_usuario === 'admin') {
                    return redirect()->route('dashboard');
                }

                if ($user->tipo_usuario === 'funcionario') {
                    return redirect()->route('funcionario.ponto');
                }

                // fallback se não for nenhum dos dois
                return redirect('/');
            }
        }

        return $next($request);
    }
}
