<?php

namespace Database\Factories;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SesiKonselingFactory extends Factory
{
    protected $model = SesiKonseling::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();

        return [
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => $this->faker->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d H:i:s'),
            'status' => 'pending'
        ];
    }
}
