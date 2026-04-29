<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed admin user (hardcoded).
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mindflow.id'],
            [
                'nama_asli' => 'Admin MindFlow',
                'nama_samaran' => 'Admin',
                'email' => 'admin@mindflow.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
