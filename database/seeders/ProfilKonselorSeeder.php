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
        $user = User::create([
            'nama_asli' => 'Asep',
            'nama_samaran' => 'Asep',
            'email' => 'asep@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'status' => 'approved'
        ]);

        $konselor1 = User::create([
            'nama_asli' => 'Rania Ar-Zahra',
            'nama_samaran' => 'Rania',
            'email' => 'rania@example.com',
            'password' => Hash::make('password'),
            'role' => 'konselor',
            'status' => 'approved'
        ]);

        $profil1 = ProfilKonselor::create([
            'user_id' => $konselor1->id,
            'nama' => 'Rania Ar-Zahra, M.Psi.',
            'spesialisasi' => 'Kesehatan Mental',
            'biografi' => 'Konselor profesional dengan pengalaman 5 tahun dalam menangani masalah kesehatan mental seperti kecemasan dan depresi.',
            'keahlian' => 'Terapi Kognitif Perilaku, Konseling Keluarga'
        ]);

        $konselor2 = User::create([
            'nama_asli' => 'Budi Rahardjo',
            'nama_samaran' => 'Budi',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'konselor',
            'status' => 'approved'
        ]);

        ProfilKonselor::create([
            'user_id' => $konselor2->id,
            'nama' => 'Budi Rahardjo, S.Psi.',
            'spesialisasi' => 'Konseling Akademik',
            'biografi' => 'Spesialis dalam membantu mahasiswa mengatasi masalah akademis dan stres belajar.',
            'keahlian' => 'Konseling Akademik, Manajemen Waktu'
        ]);

        $konselor3 = User::create([
            'nama_asli' => 'Siti Aminah',
            'nama_samaran' => 'Siti',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'konselor',
            'status' => 'approved'
        ]);

        ProfilKonselor::create([
            'user_id' => $konselor3->id,
            'nama' => 'Siti Aminah, M.Psi.',
            'spesialisasi' => 'Karir',
            'biografi' => 'Konselor karir yang membantu individu menemukan jalur karir yang sesuai dengan potensi mereka.',
            'keahlian' => 'Konseling Karir, Assessment Potensi'
        ]);

        SesiKonseling::create([
            'user_id' => $user->id,
            'profil_konselor_id' => $profil1->profil_konselor_id,
            'jadwal' => '2026-05-10 10:00:00',
            'status' => 'pending'
        ]);
    }
}
