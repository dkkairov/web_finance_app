<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создаем админа, если его нет
        User::updateOrCreate(
            [
                'email' => 'admin@example.com',
                'name' => 'admin',
                'password' => Hash::make('123'), // ← Можно задать другой пароль
                'email_verified_at' => now(),
                'preferred_currency_id' => null,
            ]
        );
        $this->call([
            CurrencySeeder::class,
            WorkspaceSeeder::class,
            UserSeeder::class,
            TransactionCategorySeeder::class,
            ProjectSeeder::class,
            LimitSeeder::class,
            TransferSeeder::class,
            MembershipSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
