<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PublicQRCodeController extends Controller
{
    public function show()
    {
        // Busca um token ativo aleatório no banco
        $token = DB::table('tokens_qr')
            ->where('status', 'ativo')
            ->inRandomOrder()
            ->first();

        // Retorna a view correta (dentro de /resources/views/public/)
        return view('public.qrcode', [
            'token' => $token?->token // operador seguro do PHP 8
        ]);
    }
}
    