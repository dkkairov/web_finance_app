<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;
use Illuminate\Support\Str;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name), // Генерируем slug
            'owner_id' => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id, // Создаем владельца (обязательно!)
            'type' => 'personal',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
