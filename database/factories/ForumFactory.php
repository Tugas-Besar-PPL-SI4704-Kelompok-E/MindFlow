<?php

namespace Database\Factories;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumFactory extends Factory
{
    protected $model = Forum::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'judul_thread' => $this->faker->sentence(),
            'konten' => $this->faker->paragraph(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
