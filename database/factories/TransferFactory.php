<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transfer;
use App\Models\Account;
use App\Models\User;
use App\Models\Currency;

class TransferFactory extends Factory
{
    protected $model = Transfer::class;

    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 10, 10000); // Генерируем случайную сумму

        return [
            'user_id' => User::factory(), // Привязываем к пользователю
            'from_account_id' => Account::factory(), // Исходящий счет
            'to_account_id' => Account::factory(), // Входящий счет
            'amount' => $amount,
            'currency_id' => $this->faker->numberBetween(1,29), // Создаст новую валюту
            'exchange_rate' => $this->faker->randomFloat(4, 0.8, 1.2), // Курс обмена (если разные валюты)
            'converted_amount' => $amount * $this->faker->randomFloat(4, 0.8, 1.2), // Сумма после конвертации
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_active' => $this->faker->boolean(), // Завершено или в ожидании
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
