<?php

namespace Database\Factories;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtikelFactory extends Factory
{
    protected $model = Artikel::class;

    public function definition(): array
    {
        return [
            'admin_id' => User::where('role', 'admin')->first()?->id ?? User::factory()->state(['role' => 'admin']),
            'judul' => $this->faker->sentence(),
            'konten' => $this->faker->paragraphs(3, true),
            'kategori' => $this->faker->randomElement(['Kesehatan Mental', 'Tips & Trik', 'Edukasi', 'Motivasi']),
            'status' => 'published',
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
        ];
    }
}
