<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\Marcacao;
use App\Models\Abono;
use App\Models\Ferias;
use App\Models\Horario;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class PontoService
{
    public function calcularEspelhoMensal(Usuario $usuario, string $mes, Horario $horario): array
    {
        $inicioMes = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
        $fimMes    = $inicioMes->copy()->endOfMonth();

        // 1. BUSCA DE DADOS
        $marcacoes = Marcacao::where('usuario_id', $usuario->id)
            ->whereBetween('data_hora', [$inicioMes, $fimMes])
            ->orderBy('data_hora')
            ->get();

        $abonos = Abono::where('usuario_id', $usuario->id)
            ->whereBetween('data', [$inicioMes, $fimMes])
            ->get()
            ->groupBy(fn($a) => Carbon::parse($a->data)->format('Y-m-d'));

        $ferias = Ferias::where('usuario_id', $usuario->id)
            ->where(fn($q) => $q->where('data_inicio', '<=', $fimMes)
                                ->where('data_fim', '>=', $inicioMes))
            ->get();

        $feriasPorDia     = $this->mapearDiasDeFerias($ferias);
        $marcacoesPorDia  = $marcacoes->groupBy(fn($m) => $m->data_hora->format('Y-m-d'));

        // 2. CÁLCULO ITERATIVO
        $totais = [
            'previsto'   => 0,
            'trabalhado' => 0,
            'extras'     => 0,
            'faltas'     => 0,
            'diasFalta'  => 0,
        ];
        $dias = [];

        for ($dia = $inicioMes->copy(); $dia->lte($fimMes); $dia->addDay()) {
            $key = $dia->format('Y-m-d');

            $previstoMin = $this->getJornadaPrevistaParaODia($dia, $horario, $feriasPorDia);
            $workedMin   = $this->calcularMinutosTrabalhados($marcacoesPorDia->get($key, collect()));
            $abonadoMin  = $this->calcularMinutosAbonados($abonos->get($key, collect()));

            $trabalhadoConsideradoMin = $workedMin + $abonadoMin;

            $status = $this->determinarStatusDoDia(
                $previstoMin,
                $trabalhadoConsideradoMin,
                $workedMin,
                $dia,
                $feriasPorDia
            );

            // Extras e faltas
            $extraMin = max(0, $trabalhadoConsideradoMin - $previstoMin);
            $faltaMin = max(0, $previstoMin - $trabalhadoConsideradoMin);

            // Acumula totais
            $totais['previsto']   += $previstoMin;
            $totais['trabalhado'] += $trabalhadoConsideradoMin; // ✅ inclui abonos
            $totais['extras']     += $extraMin;
            $totais['faltas']     += $faltaMin;

            if ($status === 'Falta') {
                $totais['diasFalta']++;
            }

            $dias[$key] = [
                'data'        => $dia->format('d/m'),
                'dia_semana'  => $dia->locale('pt_BR')->isoFormat('ddd'),
                'pontos'      => $marcacoesPorDia->get($key, collect()),
                'trabalhado'  => $trabalhadoConsideradoMin,
                'extra'       => $extraMin,
                'falta'       => $faltaMin,
                'saldo'       => $trabalhadoConsideradoMin - $previstoMin,
                'status'      => $status,
            ];
        }

        // 3. FORMATAÇÃO FINAL
        $fmt = fn(int $min) => sprintf('%02d:%02d', intdiv($min, 60), $min % 60);

        return [
            'usuario' => $usuario,
            'mes_ano' => $mes,
            'dias'    => $dias,
            'totais'  => [
                'horasPrevistas'   => $fmt($totais['previsto']),
                'horasTrabalhadas' => $fmt($totais['trabalhado']),
                'horasExtras'      => $fmt($totais['extras']),
                'horasFaltas'      => $fmt($totais['faltas']),
                'diasFalta'        => $totais['diasFalta'],
            ],
            'resumo_extras' => [
                'he_50'  => '00:00',
                'he_100' => '00:00',
            ],
        ];
    }

    // --- MÉTODOS PRIVADOS ---

    private function calcularMinutosTrabalhados(Collection $marcacoesDoDia): int
    {
        $workedMin = 0;
        $marcacoesOrdenadas = $marcacoesDoDia->sortBy('data_hora')->values();

        for ($j = 0; $j < $marcacoesOrdenadas->count(); $j += 2) {
            $in  = $marcacoesOrdenadas[$j] ?? null;
            $out = $marcacoesOrdenadas[$j + 1] ?? null;

            if ($in && $out && $in->tipo === 'entrada' && $out->tipo === 'saida') {
                $workedMin += $in->data_hora->diffInMinutes($out->data_hora);
            }
        }

        return $workedMin;
    }

    private function calcularMinutosAbonados(Collection $abonosDoDia): int
    {
        // ✅ agora considera positivo para "abonado" e negativo para "desconto"
        return $abonosDoDia->sum(fn($a) =>
            $a->tipo === 'abonado'
                ? $a->minutos
                : ($a->tipo === 'desconto' ? -$a->minutos : 0)
        );
    }

    private function mapearDiasDeFerias(Collection $ferias): array
    {
        $feriasPorDia = [];

        foreach ($ferias as $f) {
            for ($d = Carbon::parse($f->data_inicio); $d->lte(Carbon::parse($f->data_fim)); $d->addDay()) {
                $feriasPorDia[$d->format('Y-m-d')] = true;
            }
        }

        return $feriasPorDia;
    }

    private function getJornadaPrevistaParaODia(Carbon $dia, Horario $horario, array $feriasPorDia): int
    {
        if (isset($feriasPorDia[$dia->format('Y-m-d')])) {
            return 0;
        }

        switch ($dia->dayOfWeekIso) {
            case 1: return $horario->jornada_seg ?? 0;
            case 2: return $horario->jornada_ter ?? 0;
            case 3: return $horario->jornada_qua ?? 0;
            case 4: return $horario->jornada_qui ?? 0;
            case 5: return $horario->jornada_sex ?? 0;
            case 6: return $horario->jornada_sab ?? 0;
            case 7: return $horario->jornada_dom ?? 0;
            default: return 0;
        }
    }

    private function determinarStatusDoDia(int $previsto, int $considerado, int $trabalhado, Carbon $dia, array $ferias): string
    {
        if (isset($ferias[$dia->format('Y-m-d')])) return 'Férias';
        if ($previsto > 0 && $considerado == 0) return 'Falta';
        if ($previsto == 0 && $trabalhado == 0) return 'DSR';
        return 'Normal';
    }
}
