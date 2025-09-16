<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatHelper
{
    /**
     * Formata minutos para HH:mm
     */
    public static function formatarMinutos(int $totalMinutos): string
    {
        if ($totalMinutos < 0) {
            $totalMinutos = abs($totalMinutos);
            return '-' . sprintf('%02d:%02d', intdiv($totalMinutos, 60), $totalMinutos % 60);
        }

        return sprintf('%02d:%02d', intdiv($totalMinutos, 60), $totalMinutos % 60);
    }

    /**
     * Formata uma data para DD/MM/YYYY
     */
    public static function formatarData(string $data): string
    {
        return Carbon::parse($data)->timezone('America/Sao_Paulo')->format('d/m/Y');
    }

    /**
     * Formata uma data com dia da semana
     * Ex: 15/09/2025 - Segunda-feira
     */
    public static function formatarDataCompleta(string $data): string
    {
        return Carbon::parse($data)
            ->timezone('America/Sao_Paulo')
            ->locale('pt_BR')
            ->translatedFormat('d/m/Y - l');
    }

    /**
     * Formata hora no padrão Brasil
     */
    public static function formatarHora(string $dataHora): string
    {
        return Carbon::parse($dataHora)->timezone('America/Sao_Paulo')->format('H:i');
    }
}
