<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registrar comandos Artisan personalizados
     *
     * @var array<class-string>
     */
    protected $commands = [
        \App\Console\Commands\GerarTokens::class,
    ];

    /**
     * Definir a agenda de execução dos comandos
     */
    protected function schedule(Schedule $schedule)
    {
        // Gera tokens novos todo dia às 05:00
        $schedule->command('tokens:gerar')->dailyAt('05:00');
    }

    /**
     * Registrar comandos Artisan para a aplicação
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
