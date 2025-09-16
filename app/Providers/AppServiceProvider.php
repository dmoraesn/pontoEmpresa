<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\FormatHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Helpers globais disponíveis em toda a aplicação (Blade, Controller, etc.)
        if (!function_exists('formatarMinutos')) {
            function formatarMinutos(int $min): string
            {
                return FormatHelper::formatarMinutos($min);
            }
        }

        if (!function_exists('formatarData')) {
            function formatarData(string $data): string
            {
                return FormatHelper::formatarData($data);
            }
        }

        if (!function_exists('formatarDataCompleta')) {
            function formatarDataCompleta(string $data): string
            {
                return FormatHelper::formatarDataCompleta($data);
            }
        }

        if (!function_exists('formatarHora')) {
            function formatarHora(string $dataHora): string
            {
                return FormatHelper::formatarHora($dataHora);
            }
        }
    }
}
