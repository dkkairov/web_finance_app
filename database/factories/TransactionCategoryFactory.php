<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TransactionCategory;

class TransactionCategoryFactory extends Factory
{
    protected $model = TransactionCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'team_id' => 1,
            'type' => $this->faker->randomElement(['income', 'expense']), // Категория доходов или расходов
            'icon' => 'home',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
