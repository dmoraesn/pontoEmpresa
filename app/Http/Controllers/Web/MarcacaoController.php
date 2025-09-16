<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Marcacao;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MarcacaoController extends Controller
{
    // --- Métodos de CRUD Padrão (Páginas e Formulários) ---

    public function index(Request $request, Usuario $usuario)
    {
        $mesAnoSelecionado = $request->input('mes_ano', now('America/Sao_Paulo')->format('Y-m'));
        $dataFiltro = Carbon::createFromFormat('Y-m', $mesAnoSelecionado, 'America/Sao_Paulo');

        $marcacoes = Marcacao::where('usuario_id', $usuario->id)
            ->whereYear('data_hora', $dataFiltro->year)
            ->whereMonth('data_hora', $dataFiltro->month)
            ->orderBy('data_hora', 'asc')
            ->get();

        $marcacoesPorDia = $marcacoes->groupBy(fn($m) => $m->data_hora->timezone('America/Sao_Paulo')->format('Y-m-d'));

        return view('marcacoes.index', compact(
            'usuario',
            'marcacoes',
            'marcacoesPorDia',
            'mesAnoSelecionado'
        ));
    }

    public function store(Request $request, Usuario $usuario)
    {
        $request->validate([
            'tipo'      => 'required|in:entrada,saida',
            'data_hora' => 'required|date_format:d/m/Y H:i',
            'origem'    => 'nullable|string|max:50'
        ]);

        $dataHora = Carbon::createFromFormat('d/m/Y H:i', $request->data_hora, 'America/Sao_Paulo')
            ->timezone('UTC');

        Marcacao::create([
            'usuario_id' => $usuario->id,
            'tipo'       => strtolower($request->tipo),
            'data_hora'  => $dataHora,
            'origem'     => $request->origem ?? 'manual_admin'
        ]);

        return redirect()->route('usuarios.ponto.index', $usuario->id)
                         ->with('success', 'Marcação registrada com sucesso.');
    }

    public function edit(Usuario $usuario, Marcacao $marcacao)
    {
        return view('marcacoes.edit', compact('usuario', 'marcacao'));
    }

    public function update(Request $request, Usuario $usuario, Marcacao $marcacao)
    {
        $request->validate([
            'tipo'      => 'required|in:entrada,saida',
            'data_hora' => 'required|date_format:d/m/Y H:i',
        ]);

        $dataHora = Carbon::createFromFormat('d/m/Y H:i', $request->data_hora, 'America/Sao_Paulo')
            ->timezone('UTC');

        $marcacao->update([
            'tipo'      => $request->tipo,
            'data_hora' => $dataHora,
            'origem'    => $request->origem ?? $marcacao->origem,
        ]);

        return redirect()->route('usuarios.ponto.index', $usuario->id)
                         ->with('success', 'Marcação atualizada com sucesso!');
    }

    public function destroy(Usuario $usuario, Marcacao $marcacao)
    {
        $marcacao->delete();

        return redirect()
            ->route('usuarios.ponto.index', $usuario->id)
            ->with('success', 'Marcação excluída com sucesso!');
    }

    // --- Ajuste rápido via AJAX ---
    public function ajusteRapido(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'tipo'       => 'required|in:entrada,saida',
            'hora'       => 'required|date_format:H:i',
        ]);

        try {
            $dataHora = Carbon::today('America/Sao_Paulo')
                ->setTimeFromTimeString($request->hora)
                ->timezone('UTC');

            $marcacao = Marcacao::updateOrCreate(
                [
                    'usuario_id' => $request->usuario_id,
                    'tipo'       => $request->tipo,
                    'data_hora'  => Carbon::today('America/Sao_Paulo')->startOfDay()->timezone('UTC'),
                ],
                [
                    'data_hora' => $dataHora,
                    'origem'    => 'ajuste_dashboard'
                ]
            );

            return response()->json([
                'success' => true,
                'hora' => $marcacao->data_hora->timezone('America/Sao_Paulo')->format('H:i')
            ]);

        } catch (\Exception $e) {
            Log::error("Erro no ajuste rápido de ponto: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao salvar.'], 500);
        }
    }
}