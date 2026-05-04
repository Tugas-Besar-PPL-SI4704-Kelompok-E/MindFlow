<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ProfilKonselorSeeder::class,
        ]);

        // User::factory(10)->create();

<<<<<<< HEAD
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'nama_asli' => 'Test User',
                'nama_samaran' => 'tester',
                'password' => bcrypt('password'), // Or whatever default factory password is
            ]
        );
=======
        $email = 'test@example.com';
        if (!User::where('email', $email)->exists()) {
            User::factory()->create([
                'nama_asli' => 'Test User',
                'nama_samaran' => 'tester',
                'email' => $email,
            ]);
        }
>>>>>>> 01b426bde8cf49f707464f4896385ca9eff1dde8
    }
}
