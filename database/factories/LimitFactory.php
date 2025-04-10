<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Limit;
use App\Models\User;
use App\Models\TransactionCategory;
use App\Models\Team;

class LimitFactory extends Factory
{
    protected $model = Limit::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Привязываем к пользователю
            'transaction_category_id' => TransactionCategory::factory(), // Привязываем к категории транзакций
            'amount' => $this->faker->randomFloat(2, 100, 10000), // Лимит по категории
            'is_active' => $this->faker->boolean(), // true = активен, false = завершен
            'currency_id' => Currency::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
