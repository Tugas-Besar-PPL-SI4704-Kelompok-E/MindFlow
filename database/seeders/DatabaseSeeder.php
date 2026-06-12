<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SpesialisasiSeeder::class,
            ProfilKonselorSeeder::class,
            ArtikelSeeder::class,
            ThreadSeeder::class,
        ]);
    }
}