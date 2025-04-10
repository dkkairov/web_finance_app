<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Team;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'team_id' => Team::factory(), // Связываем с рабочим пространством
            'is_active' => $this->faker->boolean(), // true = активен, false = архивирован
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
