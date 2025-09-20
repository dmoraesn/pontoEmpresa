<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Marcacao;

class PontoController extends Controller
{
    public function marcar(Request $request)
    {
        $user = $request->user();
        $token = trim($request->input('token'));

        // Debug temporário
        \Log::info('🔎 Marcar ponto chamado', [
            'user_id' => $user?->id,
            'token_recebido' => $token
        ]);

        // 1. Verifica se o token existe e está ativo
        $registro = DB::table('tokens_qr')
            ->where('token', $token)
            ->where('status', 'ativo')
            ->first();

        if (!$registro) {
            return response()->json(['message' => 'QR inválido ou já usado!'], 400);
        }

        // 2. Marca como usado
        DB::table('tokens_qr')
            ->where('id', $registro->id)
            ->update([
                'status' => 'usado',
                'usado_em' => now()
            ]);

        // 3. Alterna entrada/saída
        $ultima = Marcacao::where('usuario_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->first();

        $tipo = (!$ultima || $ultima->tipo === 'saida') ? 'entrada' : 'saida';

        Marcacao::create([
            'usuario_id' => $user->id,
            'tipo' => $tipo,
            'created_at' => now()
        ]);

        return response()->json([
            'message' => ucfirst($tipo) . ' registrada com sucesso!',
            'tipo' => $tipo
        ]);
    }
}
