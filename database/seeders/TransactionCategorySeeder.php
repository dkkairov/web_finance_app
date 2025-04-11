<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionCategory;

class TransactionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'type' => 'income', 'icon' => 'add', 'team_id' => 1],
            ['name' => 'Freelance', 'type' => 'income', 'icon' => 'add', 'team_id' => 1],
            ['name' => 'Food', 'type' => 'expense', 'icon' => 'add', 'team_id' => 1],
            ['name' => 'Rent', 'type' => 'expense', 'icon' => 'add', 'team_id' => 1],
            ['name' => 'Entertainment', 'type' => 'expense', 'icon' => 'add', 'team_id' => 1],
        ];

        foreach ($categories as $category) {
            TransactionCategory::firstOrCreate(['name' => $category['name']], ['type' => $category['type']], ['icon' => $category['type'], 'team_id' => $category['team_id']]);
        }
    }
}
