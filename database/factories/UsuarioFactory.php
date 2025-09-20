<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nome'  => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf'   => $this->faker->unique()->numerify('###########'), // 11 dígitos
            'cargo' => $this->faker->jobTitle(),
            'ativo' => true,
        ];
    }
}
