<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Categoria> */
class CategoriaFactory extends Factory
{
    /** @return array{user_id: UserFactory, nome: string, tipo: string} */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nome' => fake()->word(),
            'tipo' => 'despesa',
        ];
    }
}
