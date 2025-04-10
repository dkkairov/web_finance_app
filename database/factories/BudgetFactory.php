<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Budget;
use App\Models\User;
use App\Models\Team;
use App\Models\Currency;

class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Создаем пользователя
            'team_id' => Team::factory(), // Привязываем к рабочему пространству
            'currency_id' => Currency::factory(), // Валюта бюджета
            'name' => $this->faker->word(), // Название бюджета
            'amount' => $this->faker->randomFloat(2, 100, 10000), // Сумма бюджета
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'is_active' => $this->faker->boolean(), // Активен/неактивен
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
