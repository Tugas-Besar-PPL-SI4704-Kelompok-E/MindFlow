<?php

namespace Database\Factories;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilKonselorFactory extends Factory
{
    protected $model = ProfilKonselor::class;

    public function definition(): array
    {
        $user = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved'
        ]);

        $spesialisasi = ['Kesehatan Mental', 'Konseling Akademik', 'Karir'];

        return [
            'user_id' => $user->id,
            'nama' => $this->faker->name . ', M.Psi.',
            'spesialisasi' => $this->faker->randomElement($spesialisasi),
            'biografi' => $this->faker->paragraph,
            'keahlian' => $this->faker->sentence
        ];
    }
}
