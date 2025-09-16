<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Marcacao;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EspelhoController extends Controller
{
    public function show($usuarioId, Request $request)
    {
        $ano = $request->input('ano', date('Y'));
        $mes = $request->input('mes', date('m'));

        $usuario = Usuario::findOrFail($usuarioId);

        // Marcações do mês
        $marcacoes = Marcacao::where('usuario_id', $usuarioId)
            ->whereYear('data_hora', $ano)
            ->whereMonth('data_hora', $mes)
            ->orderBy('data_hora')
            ->get();

        // Agrupar por dia
        $dias = $marcacoes->groupBy(function ($item) {
            return Carbon::parse($item->data_hora)->format('Y-m-d');
        });

        $resumo = [
            'horas_trabalhadas' => 0,
            'extras' => 0,
            'faltas' => 0,
            'total' => 0,
        ];

        $detalhes = [];

        foreach ($dias as $data => $pontos) {
            $entrada = $pontos->first()->data_hora ?? null;
            $saida = $pontos->last()->data_hora ?? null;

            $ht = 0; // horas trabalhadas
            $ex = 0; // extras
            $fa = 0; // faltas

            if ($entrada && $saida && $entrada != $saida) {
                $ht = Carbon::parse($entrada)->diffInMinutes(Carbon::parse($saida));
                if ($ht > 480) { // 8h base
                    $ex = $ht - 480;
                    $ht = 480;
                }
            } else {
                $fa = 480; // falta equivalente a 8h
            }

            $resumo['horas_trabalhadas'] += $ht;
            $resumo['extras'] += $ex;
            $resumo['faltas'] += $fa;

            $detalhes[] = [
                'data' => Carbon::parse($data)->format('d/m/Y D'),
                'entrada' => $entrada ? Carbon::parse($entrada)->format('H:i') : '--',
                'saida' => $saida ? Carbon::parse($saida)->format('H:i') : '--',
                'ht' => $this->formatMinutes($ht),
                'ex' => $this->formatMinutes($ex),
                'fa' => $this->formatMinutes($fa),
            ];
        }

        $resumo['total'] = $this->formatMinutes(
            $resumo['horas_trabalhadas'] + $resumo['extras']
        );

        // formatar horas
        $resumo['horas_trabalhadas'] = $this->formatMinutes($resumo['horas_trabalhadas']);
        $resumo['extras'] = $this->formatMinutes($resumo['extras']);
        $resumo['faltas'] = $this->formatMinutes($resumo['faltas']);

        return view('espelho.index', compact('usuario', 'detalhes', 'resumo', 'ano', 'mes'));
    }

    private function formatMinutes($minutos)
    {
        $h = floor($minutos / 60);
        $m = $minutos % 60;
        return sprintf('%02d:%02d', $h, $m);
    }
}
