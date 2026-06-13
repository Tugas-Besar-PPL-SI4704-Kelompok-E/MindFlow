<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => $this->faker->paragraph(),
            'is_anonymous' => $this->faker->boolean(20),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
