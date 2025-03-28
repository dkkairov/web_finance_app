<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Workspace;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'workspace_id' => Workspace::factory(), // Связываем с рабочим пространством
            'is_active' => $this->faker->boolean(), // true = активен, false = архивирован
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
