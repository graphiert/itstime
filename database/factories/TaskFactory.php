<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(2),
            'due' => fake()->dateTimeBetween('-2 weeks', '+2 weeks'),
            'done' => fake()->dateTimeBetween('-1 week', '+4 weeks'),
            'user_id' => 1,
        ];
    }
}
