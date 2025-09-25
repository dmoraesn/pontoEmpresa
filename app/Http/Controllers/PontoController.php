<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Marcacao;
use Carbon\Carbon;

class PontoController extends Controller
{
    /**
     * Exibe a tela inicial para o funcionário marcar o ponto.
     */
    public function index()
    {
        // Última marcação do usuário logado NO DIA DE HOJE
        $ultimaMarcacao = Marcacao::where('usuario_id', Auth::id())
            ->whereDate('data_hora', Carbon::today()) // Adicionado para filtrar pela data de hoje
            ->orderBy('data_hora', 'desc')
            ->first();

        return view('funcionario.ponto', compact('ultimaMarcacao'));
    }

    /**
     * Registra a marcação de ponto exclusivamente via QR Code.
     */
    public function marcar(Request $request)
    {
        $user = $request->user();
        $token = trim($request->input('token', ''));

        // 1. Valida token QR
        $registro = DB::table('tokens_qr')
            ->where('token', $token)
            ->where('status', 'ativo')
            ->first();

        if (!$registro) {
            return response()->json(['message' => 'QR inválido ou já usado!'], 400);
        }

        // 2. Define se é entrada ou saída
        $tipo = $this->alternarTipo($user->id);

        // 3. Transação
        try {
            DB::transaction(function () use ($registro, $user, $tipo) {
                // Invalida token
                DB::table('tokens_qr')
                    ->where('id', $registro->id)
                    ->update([
                        'status'   => 'usado',
                        'usado_em' => now(),
                    ]);

                // Cria marcação
                Marcacao::create([
                    'usuario_id' => $user->id,
                    'tipo'       => $tipo,
                    'data_hora'  => now(),
                    'origem'     => 'web_qr',
                ]);
            });
        } catch (\Exception $e) {
            \Log::error('Erro ao registrar ponto: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao registrar ponto.'], 500);
        }

        return response()->json([
            'message' => ucfirst($tipo) . ' registrada com sucesso!',
            'tipo'    => $tipo
        ]);
    }

    /**
     * Exibe o histórico de marcações do funcionário logado.
     */
    public function historico()
    {
        $marcacoes = Marcacao::where('usuario_id', Auth::id())
            ->orderBy('data_hora', 'desc')
            ->paginate(10);

        return view('funcionario.historico', compact('marcacoes'));
    }

    /**
     * Alterna automaticamente entre Entrada e Saída.
     */
    private function alternarTipo($usuarioId)
    {
        $ultima = Marcacao::where('usuario_id', $usuarioId)
            ->whereDate('data_hora', now()->toDateString())
            ->orderBy('data_hora', 'desc')
            ->first();

        return (!$ultima || $ultima->tipo === 'Saída') ? 'Entrada' : 'Saída';
    }
}
