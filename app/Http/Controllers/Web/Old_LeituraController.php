<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marcacao;
use Carbon\Carbon;

class LeituraController extends Controller
{
    public function scan()
    {
        if (!session('usuario_logado')) {
            return redirect()->route('leitura.form');
        }

        return view('leitura.scan');
    }

    public function registrar(Request $request)
    {
        $usuarioId = session('usuario_id');

        if (!$usuarioId) {
            return response()->json(['mensagem' => 'Usuário não autenticado.'], 401);
        }

        $agora = Carbon::now();

        Marcacao::create([
            'usuario_id' => $usuarioId,
            'data'       => $agora->toDateString(),
            'hora'       => $agora->format('H:i:s'),
            'tipo'       => 'entrada', // ou outro valor se necessário
            'justificativa' => 'Registrado via QR',
        ]);

        return response()->json([
            'mensagem' => 'Presença registrada com sucesso para ' . $agora->format('d/m/Y H:i:s'),
        ]);
    }
}
