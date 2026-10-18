<?php

namespace Database\Factories;

use App\Models\Carteira;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Carteira> */
class CarteiraFactory extends Factory
{
    /** @return array{user_id: UserFactory, nome: string} */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nome' => fake()->words(2, true),
        ];
    }
}
