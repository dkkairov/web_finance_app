<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Limit;

class LimitSeeder extends Seeder
{
    public function run(): void
    {
        Limit::factory()->count(15)->create(); // Создаст 15 лимитов
    }
}
