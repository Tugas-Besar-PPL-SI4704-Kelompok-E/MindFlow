<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\ThreadReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadReplyFactory extends Factory
{
    protected $model = ThreadReply::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'thread_id' => Thread::factory(),
            'content' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
