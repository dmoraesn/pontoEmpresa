<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GerarTokens extends Command
{
    /**
     * Nome e assinatura do comando
     *
     * @var string
     */
    protected $signature = 'tokens:gerar {quantidade=100}';

    /**
     * Descrição do comando
     *
     * @var string
     */
    protected $description = 'Gera tokens aleatórios para QR Codes válidos do dia';

    /**
     * Executa o comando
     */
    public function handle()
    {
        $quantidade = (int) $this->argument('quantidade');

        // Apaga tokens antigos ainda não usados
        DB::table('tokens_qr')->where('status', 'ativo')->delete();

        $tokensGerados = [];

        while (count($tokensGerados) < $quantidade) {
            $novo = $this->gerarToken();

            // Evita duplicados
            if (!in_array($novo, $tokensGerados)) {
                $tokensGerados[] = $novo;

                DB::table('tokens_qr')->insert([
                    'token' => $novo,
                    'status' => 'ativo'
                ]);
            }
        }

        $this->info("✅ Foram gerados {$quantidade} tokens para hoje.");
    }

    /**
     * Gera um token no formato XXX-XXX com 2 números
     */
    private function gerarToken()
    {
        $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeros = '0123456789';

        // Gera 6 caracteres, garantindo 2 números
        $token = [];
        $posicoesNumeros = array_rand(range(0, 5), 2);

        for ($i = 0; $i < 6; $i++) {
            if (in_array($i, (array) $posicoesNumeros)) {
                $token[] = $numeros[rand(0, 9)];
            } else {
                $token[] = $letras[rand(0, 25)];
            }
        }

        // Formata como XXX-XXX
        return substr(implode('', $token), 0, 3) . '-' . substr(implode('', $token), 3, 3);
    }
}
