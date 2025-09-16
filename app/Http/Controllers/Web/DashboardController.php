<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Marcacao;
use App\Models\Abono;
use App\Models\Ferias;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = Carbon::today();

        // Estatísticas principais
        $usuarios = Usuario::count();
        $marcacoesHoje = Marcacao::whereDate('data_hora', $hoje)->count();
        $abonosMes = Abono::whereMonth('data', $hoje->month)->count();
        $feriasHoje = Ferias::whereDate('data_inicio', '<=', $hoje)
            ->whereDate('data_fim', '>=', $hoje)
            ->count();

        // Carregar funcionários com marcações de hoje
        $funcionarios = Usuario::with(['marcacoes' => function ($query) use ($hoje) {
            $query->whereDate('data_hora', $hoje)->orderBy('data_hora');
        }])->get();

        // Data/hora para exibição no canto superior direito
        $dataAtual = Carbon::now()->translatedFormat('d/m/Y H:i');

        return view('dashboard', compact(
            'usuarios',
            'marcacoesHoje',
            'abonosMes',
            'feriasHoje',
            'funcionarios',
            'dataAtual'
        ));
    }
}
