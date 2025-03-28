<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        Membership::factory()->count(20)->create(); // Создаст 20 участников в рабочих пространствах
    }
}
