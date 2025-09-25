<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PontoController extends Controller
{
    public function bater(Request $request)
    {
        // ✅ Validação do token QR
        $request->validate([
            'token_qr' => ['required', 'regex:/^[A-Z0-9]{3}-[A-Z0-9]{3}$/'],
        ]);

        $usuario = Auth::user();

        // 1. Buscar o token QR no banco
        $tokenQr = DB::table('tokens_qr')
            ->where('token', $request->token_qr)
            ->first();

        if (!$tokenQr || $tokenQr->status !== 'ativo') {
            return response()->json([
                'message' => 'QR Code inválido ou já utilizado.'
            ], 400);
        }

        // 2. Pegar última marcação do dia (usando data_hora)
        $ultimaMarcacao = DB::table('marcacoes')
            ->where('usuario_id', $usuario->id)
            ->whereDate('data_hora', now()->toDateString())
            ->orderByDesc('data_hora')
            ->first();

        // 3. Alternar entre Entrada e Saída
        $tipoMarcacao = ($ultimaMarcacao && $ultimaMarcacao->tipo === 'Entrada')
            ? 'Saída'
            : 'Entrada';

        // 4. Inserir nova marcação
        DB::table('marcacoes')->insert([
            'usuario_id' => $usuario->id,
            'tipo'       => $tipoMarcacao,
            'data_hora'  => now(),
            'origem'     => 'app_qr',
        ]);

        // 5. Marcar token como usado
        DB::table('tokens_qr')
            ->where('id', $tokenQr->id)
            ->update([
                'status'   => 'usado',
                'usado_em' => now(),
            ]);

        return response()->json([
            'message' => 'Ponto batido com sucesso!',
            'tipo'    => $tipoMarcacao,
            'token'   => $request->token_qr
        ], 200);
    }
}
