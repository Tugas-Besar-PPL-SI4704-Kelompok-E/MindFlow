<?php

namespace Database\Factories;

use App\Models\ArtikelReport;
use App\Models\Artikel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtikelReportFactory extends Factory
{
    protected $model = ArtikelReport::class;

    public function definition(): array
    {
        return [
            'artikel_id' => Artikel::factory(),
            'user_id' => User::factory(),
            'reason' => $this->faker->randomElement([
                'Inaccurate information',
                'Plagiarism',
                'Offensive content',
                'Broken links'
            ]),
            'status' => $this->faker->randomElement(['pending', 'resolved', 'ignored']),
            'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
