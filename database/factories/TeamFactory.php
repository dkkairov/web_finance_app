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
            'slug' => Str::slug($name).' team', // Генерируем slug
            'owner_id' => 1,
            'type' => 'personal',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
