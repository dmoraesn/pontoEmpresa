<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Se quiser, pode criar um usuário de exemplo aqui:
        // \App\Models\Usuario::factory()->create([
        //     'nome' => 'Administrador',
        // ]);

        // Criar afastamentos fake
        \App\Models\Afastamento::factory(20)->create();
    }
    public function run(): void
{
    $this->call(UsuarioSeeder::class);
}

}
