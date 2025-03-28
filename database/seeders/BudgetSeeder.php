<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        Budget::factory()->count(10)->create(); // Создаст 10 бюджетов
    }
}
