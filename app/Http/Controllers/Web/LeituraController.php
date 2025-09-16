<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marcacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeituraController extends Controller
{
    /**
     * Exibe o formulário de login/página de geração do QR.
     *
     * @return \Illuminate\View\View
     */
    public function form()
    {
        return view('leitura.form'); // página com o QR gerado
    }

    /**
     * Exibe a página de escaneamento do QR Code.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function scan()
    {
        if (!Auth::check()) {
            return redirect()->route('leitura.form');
        }

        return view('leitura.scan');
    }

    /**
     * Registra a presença a partir do token do QR Code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request)
    {
        // Validação básica
        $request->validate([
            'token' => 'required|string'
        ]);

        $usuario = Auth::user();

        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não autenticado.'], 401);
        }

        // Registro da marcação
        Marcacao::create([
            'user_id' => $usuario->id,
            'data_hora' => Carbon::now(),
            'tipo' => 'entrada',
            'token_lido' => $request->token
        ]);

        return response()->json(['mensagem' => 'Presença registrada com sucesso!']);
    }

    /**
     * Gera e retorna um token aleatório para o front-end.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function gerarToken()
    {
        // Ex: XR1-AS2
        $gerarParte = function () {
            return strtoupper(
                chr(rand(65, 90)) . chr(rand(65, 90)) . rand(1, 9)
            );
        };

        $token = $gerarParte() . '-' . $gerarParte();

        return response()->json([
            'token' => $token,
            'timestamp' => now()->timestamp
        ]);
    }

    /**
     * Realiza o logout do usuário.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('leitura.form');
    }
}