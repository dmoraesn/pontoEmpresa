<?php

if (!function_exists('formatarMinutos')) {
    /**
     * Formata um valor em minutos para o formato HH:mm.
     */
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