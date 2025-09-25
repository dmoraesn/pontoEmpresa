<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria um usuário inicial
        Usuario::updateOrCreate(
            ['email' => 'bruno@test.com'], // evita duplicar se já existir
            [
                'nome' => 'Bruno',
                'cpf' => '12345678900',
                'cargo' => 'Administrador',
                'ativo' => true,
                'password' => Hash::make('123456'),
            ]
        );
    }
}
