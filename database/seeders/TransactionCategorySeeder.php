<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionCategory;

class TransactionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'type' => 'income'],
            ['name' => 'Freelance', 'type' => 'income'],
            ['name' => 'Food', 'type' => 'expense'],
            ['name' => 'Rent', 'type' => 'expense'],
            ['name' => 'Entertainment', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            TransactionCategory::firstOrCreate(['name' => $category['name']], ['type' => $category['type']], ['user_id' => $category['user_id']]);
        }
    }
}
