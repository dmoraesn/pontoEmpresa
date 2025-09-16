<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function form()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $usuarioInput = $request->input('usuario');
        $senhaInput = $request->input('senha');

        // Login fixo para admin
        if ($usuarioInput === 'admin' && $senhaInput === '2025') {
            $usuario = Usuario::where('nome', 'Bruno')->first();

            if (!$usuario) {
                return back()->withErrors(['Usuário "Bruno" não encontrado na base.']);
            }

            session([
                'usuario_logado' => true,
                'usuario_id' => $usuario->id,
            ]);

            return redirect()->route('leitura.scan');
        }

        return back()->withErrors(['Credenciais inválidas.']);
    }
}
