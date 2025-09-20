<?php

namespace Database\Factories;

use App\Models\Afastamento;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class AfastamentoFactory extends Factory
{
    protected $model = Afastamento::class;

    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(), // cria ou usa usuário fake
            'tipo' => $this->faker->randomElement(['FÉRIAS', 'LICENÇA MÉDICA', 'LICENÇA MATERNIDADE', 'OUTRO']),
            'data_inicio' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'data_fim' => $this->faker->optional()->dateTimeBetween('now', '+3 months'),
            'observacao' => $this->faker->optional()->sentence(),
        ];
    }
}
