<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTipoUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $tipo Tipo esperado: "admin" ou "funcionario"
     */
    public function handle(Request $request, Closure $next, string $tipo): Response
    {
        // Se não estiver logado → manda para login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        $user = Auth::user();

        // Se não for do tipo esperado → redireciona
        if ($user->tipo_usuario !== $tipo) {
            return $this->redirectByRole($user->tipo_usuario);
        }

        return $next($request);
    }

    /**
     * Redireciona para a área correta de acordo com o tipo de usuário.
     */
    private function redirectByRole(?string $role): Response
    {
        return match ($role) {
            'admin'       => redirect()->route('dashboard')
                                ->with('error', 'Área restrita a administradores.'),
            'funcionario' => redirect()->route('funcionario.ponto')
                                ->with('error', 'Área restrita a funcionários.'),
            default       => redirect()->route('login')
                                ->with('error', 'Acesso negado.'),
        };
    }
}
