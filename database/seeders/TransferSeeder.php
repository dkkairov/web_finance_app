<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transfer;

class TransferSeeder extends Seeder
{
    public function run(): void
    {
        Transfer::factory()->count(10)->create(); // Создаст 10 переводов
    }
}
