<?php

namespace Database\Factories;

use App\Models\LaporanForum;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanForumFactory extends Factory
{
    protected $model = LaporanForum::class;

    public function definition(): array
    {
        return [
            'forum_id' => Forum::factory(),
            'pelapor_id' => User::factory(),
            'alasan_laporan' => $this->faker->sentence(),
            'status_tindak_lanjut' => $this->faker->randomElement(['pending', 'dihapus', 'diabaikan']),
            'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
