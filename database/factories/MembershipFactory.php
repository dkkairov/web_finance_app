<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membership;
use App\Models\User;
use App\Models\Workspace;

class MembershipFactory extends Factory
{
    protected $model = Membership::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Привязываем к пользователю
            'workspace_id' => Workspace::factory(), // Привязываем к рабочему пространству
            'role' => $this->faker->randomElement(['owner', 'admin', 'member']), // Роль участника
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
