<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pendiente', 'en_progreso', 'completada']),
            'user_id' => User::factory(),
        ];
    }
}
