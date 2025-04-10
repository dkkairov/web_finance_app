<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use App\Models\User;
use App\Models\Currency;
use App\Models\Team;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . ' Account',
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'team_id' => Team::factory(), // Создаст новое рабочее пространство
            'currency_id' => Currency::factory(), // Создаст новую валюту
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
