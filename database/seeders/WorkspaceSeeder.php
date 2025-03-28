<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Workspace;

class WorkspaceSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::first() ?? User::factory()->create([

        ]); // Создаём владельца один раз

        Workspace::factory()->count(10)->create([
            'owner_id' => $owner->id, // Передаём owner_id, чтобы избежать рекурсии
        ]);
    }
}
