<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spesialisasi;

class SpesialisasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Kesehatan Mental',
            'Konseling Akademik',
            'Karir',
            'Klinis & Depresi',
            'Konseling Remaja',
            'Konseling Keluarga',
        ];

        foreach ($data as $nama) {
            Spesialisasi::firstOrCreate(['nama' => $nama]);
        }
    }
}
