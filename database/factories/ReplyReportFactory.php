<?php

namespace Database\Factories;

use App\Models\ReplyReport;
use App\Models\ThreadReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyReportFactory extends Factory
{
    protected $model = ReplyReport::class;

    public function definition(): array
    {
        return [
            'thread_reply_id' => ThreadReply::factory(),
            'user_id' => User::factory(),
            'reason' => $this->faker->randomElement([
                'Spam',
                'Hate Speech',
                'Harassment',
                'Toxic behavior',
                'Irrelevant'
            ]),
            'status' => $this->faker->randomElement(['pending', 'resolved', 'ignored']),
            'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
