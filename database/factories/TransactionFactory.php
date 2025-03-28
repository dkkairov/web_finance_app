<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\TransactionCategory;
use App\Models\Project;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, -5000, 5000), // Случайная сумма дохода/расхода
            'description' => $this->faker->sentence(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'transaction_category_id' => TransactionCategory::factory(), // Создаст новую категорию
            'account_id' => Account::factory(), // Создаст новый счет
            'project_id' => Project::factory(),
            'is_active' => $this->faker->boolean(), // true = завершена, false = ожидает
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
