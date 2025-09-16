<?php

use Carbon\Carbon;

if (!function_exists('formatarMinutos')) {
    function formatarMinutos(int $totalMinutos): string
    {
        $sinal = '';
        if ($totalMinutos < 0) {
            $sinal = '-';
            $totalMinutos = abs($totalMinutos);
        }
        return $sinal . sprintf('%02d:%02d', intdiv($totalMinutos, 60), $totalMinutos % 60);
    }
}

if (!function_exists('formatarData')) {
    function formatarData(string|\DateTime $data): string
    {
        return Carbon::parse($data)->timezone('America/Sao_Paulo')->translatedFormat('d/m/Y');
    }
}

if (!function_exists('formatarHora')) {
    function formatarHora(string|\DateTime $data): string
    {
        return Carbon::parse($data)->timezone('America/Sao_Paulo')->format('H:i');
    }
}
