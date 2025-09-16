<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Marcacao;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MarcacaoController extends Controller
{
    // --- Métodos de CRUD Padrão (Páginas e Formulários) ---

    public function index(Request $request, Usuario $usuario)
    {
        $mesAnoSelecionado = $request->input('mes_ano', now()->format('Y-m'));
        $dataFiltro = Carbon::createFromFormat('Y-m', $mesAnoSelecionado);

        $marcacoes = Marcacao::where('usuario_id', $usuario->id)
            ->whereYear('data_hora', $dataFiltro->year)
            ->whereMonth('data_hora', $dataFiltro->month)
            ->orderBy('data_hora', 'asc')
            ->get();

        $marcacoesPorDia = $marcacoes->groupBy(fn($marcacao) => $marcacao->data_hora->format('Y-m-d'));

        return view('marcacoes.index', compact(
            'usuario', 
            'marcacoesPorDia', 
            'mesAnoSelecionado'
        ));
    }

    public function store(Request $request, Usuario $usuario)
    {
        $request->validate([
            'tipo'      => 'required|in:entrada,saida',
            'data_hora' => 'required|date',
        ]);

        Marcacao::create([
            'usuario_id' => $usuario->id,
            'tipo'       => strtolower($request->tipo),
            'data_hora'  => Carbon::parse($request->data_hora),
            'origem'     => 'manual_admin'
        ]);

        return redirect()->route('usuarios.ponto.index', $usuario->id)
                         ->with('success', 'Marcação registrada com sucesso.');
    }

    public function edit(Marcacao $marcacao)
    {
        return view('marcacoes.edit', compact('marcacao'));
    }

    public function update(Request $request, Marcacao $marcacao)
    {
        $request->validate([
            'tipo'      => 'required|in:entrada,saida',
            'data_hora' => 'required|date',
        ]);

        $marcacao->update([
            'tipo'      => $request->tipo,
            'data_hora' => Carbon::parse($request->data_hora),
        ]);

        return redirect()->back()->with('success', 'Marcação atualizada com sucesso!');
    }

    public function destroy(Marcacao $marcacao)
    {
        $marcacao->delete();
        return redirect()->back()->with('success', 'Marcação excluída com sucesso!');
    }

    // --- Métodos de AJAX ---

    /**
     * Cria ou atualiza uma marcação a partir da edição rápida do Dashboard.
     */
    public function ajusteRapido(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'tipo'       => 'required|in:entrada,saida',
            'hora'       => 'required|date_format:H:i',
        ]);

        try {
            $dataHora = Carbon::today()->setTimeFromTimeString($request->hora);
            
            // Usamos updateOrCreate para encontrar ou criar o registro em uma única operação
            $marcacao = Marcacao::updateOrCreate(
                [
                    'usuario_id' => $request->usuario_id,
                    'tipo'       => $request->tipo,
                    'data_hora'  => Carbon::today()->startOfDay(), // Compara apenas a data
                ],
                [
                    'data_hora' => $dataHora,
                    'origem'    => 'ajuste_dashboard'
                ]
            );

            // Se chegamos aqui, a operação foi bem-sucedida
            return response()->json([
                'success' => true,
                'hora' => $marcacao->data_hora->format('H:i')
            ]);

        } catch (\Exception $e) {
            Log::error("Erro no ajuste rápido de ponto: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erro ao salvar.'], 500);
        }
    }
}