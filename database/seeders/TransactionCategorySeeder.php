<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionCategory;

class TransactionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'type' => 'income', 'icon' => 'add',],
            ['name' => 'Freelance', 'type' => 'income', 'icon' => 'add',],
            ['name' => 'Food', 'type' => 'expense', 'icon' => 'add',],
            ['name' => 'Rent', 'type' => 'expense', 'icon' => 'add',],
            ['name' => 'Entertainment', 'type' => 'expense', 'icon' => 'add',],
        ];

        foreach ($categories as $category) {
            TransactionCategory::firstOrCreate(['name' => $category['name']], ['type' => $category['type']], ['icon' => $category['type']]);
        }
    }
}
