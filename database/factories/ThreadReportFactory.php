<?php

namespace Database\Factories;

use App\Models\ThreadReport;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadReportFactory extends Factory
{
    protected $model = ThreadReport::class;

    public function definition(): array
    {
        return [
            'thread_id' => Thread::factory(),
            'user_id' => User::factory(),
            'reason' => $this->faker->randomElement([
                'Spam',
                'Hate Speech',
                'Harassment',
                'Inappropriate Content',
                'Self-harm',
                'Misinformation'
            ]),
            'status' => $this->faker->randomElement(['pending', 'resolved', 'ignored']),
            'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
