<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function form()
    {
        return view('auth.login');
    }

    /**
     * Processa a autenticação do usuário.
     */
    public function auth(Request $request)
    {
        // Valida dados de entrada
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Autentica
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Usuário ou senha incorretos.',
            ]);
        }

        // Regenera sessão para evitar fixation
        $request->session()->regenerate();

        $user = Auth::user();

        // Redireciona por tipo
        return $user->tipo_usuario === 'funcionario'
            ? redirect()->route('funcionario.ponto')
            : redirect()->route('dashboard');
    }

    /**
     * Faz logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Você saiu da sua conta com sucesso.');
    }
}
