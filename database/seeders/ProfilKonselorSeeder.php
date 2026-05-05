<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfilKonselorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'asep@example.com'],
            [
                'nama_asli' => 'Asep',
                'nama_samaran' => 'Asep',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'approved'
            ]
        );

        $konselor1 = User::firstOrCreate(
            ['email' => 'rania@example.com'],
            [
                'nama_asli' => 'Rania Ar-Zahra',
                'nama_samaran' => 'Rania',
                'password' => Hash::make('password'),
                'role' => 'konselor',
                'status' => 'approved'
            ]
        );

        $profil1 = ProfilKonselor::firstOrCreate(
            ['user_id' => $konselor1->id],
            [
                'nama' => 'Rania Ar-Zahra, M.Psi.',
                'spesialisasi' => 'Kesehatan Mental',
                'biografi' => 'Konselor profesional dengan pengalaman 5 tahun dalam menangani masalah kesehatan mental seperti kecemasan dan depresi.',
                'keahlian' => 'Terapi Kognitif Perilaku, Konseling Keluarga'
            ]
        );

        $konselor2 = User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'nama_asli' => 'Budi Rahardjo',
                'nama_samaran' => 'Budi',
                'password' => Hash::make('password'),
                'role' => 'konselor',
                'status' => 'approved'
            ]
        );

        ProfilKonselor::firstOrCreate(
            ['user_id' => $konselor2->id],
            [
                'nama' => 'Budi Rahardjo, S.Psi.',
                'spesialisasi' => 'Konseling Akademik',
                'biografi' => 'Spesialis dalam membantu mahasiswa mengatasi masalah akademis dan stres belajar.',
                'keahlian' => 'Konseling Akademik, Manajemen Waktu'
            ]
        );

        $konselor3 = User::firstOrCreate(
            ['email' => 'siti@example.com'],
            [
                'nama_asli' => 'Siti Aminah',
                'nama_samaran' => 'Siti',
                'password' => Hash::make('password'),
                'role' => 'konselor',
                'status' => 'approved'
            ]
        );

        ProfilKonselor::firstOrCreate(
            ['user_id' => $konselor3->id],
            [
                'nama' => 'Siti Aminah, M.Psi.',
                'spesialisasi' => 'Karir',
                'biografi' => 'Konselor karir yang membantu individu menemukan jalur karir yang sesuai dengan potensi mereka.',
                'keahlian' => 'Konseling Karir, Assessment Potensi'
            ]
        );

        SesiKonseling::firstOrCreate(
            [
                'user_id' => $user->id,
                'profil_konselor_id' => $profil1->profil_konselor_id,
                'jadwal' => '2026-05-10 10:00:00'
            ],
            [
                'status' => 'pending'
            ]
        );
    }
}