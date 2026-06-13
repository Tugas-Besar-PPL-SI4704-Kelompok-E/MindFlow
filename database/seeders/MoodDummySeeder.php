<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HasilCheckInstan;
use App\Models\HasilCheckMendalam;
use App\Models\HasilDass21;
use Carbon\Carbon;

class MoodDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asep = User::where('email', 'asep@example.com')->first();
        if (!$asep) {
            $this->command->error("User Asep dengan email asep@example.com tidak ditemukan!");
            return;
        }

        $this->command->info("Seeding data dummy mood untuk Asep (User ID: {$asep->id})...");

        // 1. Seed HasilCheckInstan (Pemeriksaan Singkat) selama 7 hari terakhir
        $moods = [
            ['skor' => 8, 'days_ago' => 6], // Baik
            ['skor' => 7, 'days_ago' => 5], // Baik
            ['skor' => 5, 'days_ago' => 4], // Biasa
            ['skor' => 3, 'days_ago' => 3, 'story' => 'Hari ini cukup berat, banyak tugas kuliah menumpuk dan revisi ditolak dosen.'], // Buruk
            ['skor' => 4, 'days_ago' => 2, 'story' => 'Masih merasa tertekan dengan deadline projek akhir. Tidur jadi kurang nyenyak.'], // Buruk
            ['skor' => 6, 'days_ago' => 1], // Biasa
            ['skor' => 9, 'days_ago' => 0], // Baik (Hari ini)
        ];

        foreach ($moods as $m) {
            $createdTime = Carbon::now()->subDays($m['days_ago'])->setHour(10)->setMinute(0);

            // Raw query or create to make sure timestamps can be set/manipulated
            // Since $timestamps is false and only created_at is handled, we can pass it or update it directly
            $check = new HasilCheckInstan();
            $check->user_id = $asep->id;
            $check->poin_skor = $m['skor'];
            $check->kategori_hasil = HasilCheckInstan::determineKategori($m['skor']);
            $check->is_mendalam_offered = ($m['skor'] <= 4);
            $check->created_at = $createdTime;
            $check->save();

            // Jika ada cerita/open question
            if (isset($m['story'])) {
                $mendalam = new HasilCheckMendalam();
                $mendalam->check_instan_id = $check->check_instan_id;
                $mendalam->user_id = $asep->id;
                $mendalam->jawaban_terbuka = $m['story'];
                $mendalam->created_at = $createdTime->copy()->addMinutes(5);
                $mendalam->save();
            }
        }

        // 2. Seed HasilDass21 (Pemeriksaan Mendalam)
        // Sesi DASS-21 pertama (5 hari yang lalu) - Sedang
        $responses1 = [];
        for ($i = 1; $i <= 21; $i++) {
            // Campuran skor 1, 2, 0
            $responses1[] = [
                'question_id' => $i,
                'score' => ($i % 3 === 0) ? 2 : (($i % 2 === 0) ? 1 : 0)
            ];
        }
        $scores1 = HasilDass21::hitungSkor($responses1);
        
        $dass1 = new HasilDass21();
        $dass1->user_id = $asep->id;
        $dass1->skor_depresi = $scores1['skor_depresi'];
        $dass1->skor_kecemasan = $scores1['skor_kecemasan'];
        $dass1->skor_stres = $scores1['skor_stres'];
        $dass1->total_skor = $scores1['total_skor'];
        $dass1->kategori_depresi = $scores1['kategori_depresi'];
        $dass1->kategori_kecemasan = $scores1['kategori_kecemasan'];
        $dass1->kategori_stres = $scores1['kategori_stres'];
        $dass1->detail_jawaban = $responses1;
        $dass1->created_at = Carbon::now()->subDays(5)->setHour(14)->setMinute(30);
        $dass1->save();

        // Sesi DASS-21 kedua (2 hari yang lalu) - Ringan/Normal
        $responses2 = [];
        for ($i = 1; $i <= 21; $i++) {
            $responses2[] = [
                'question_id' => $i,
                'score' => ($i % 5 === 0) ? 1 : 0
            ];
        }
        $scores2 = HasilDass21::hitungSkor($responses2);
        
        $dass2 = new HasilDass21();
        $dass2->user_id = $asep->id;
        $dass2->skor_depresi = $scores2['skor_depresi'];
        $dass2->skor_kecemasan = $scores2['skor_kecemasan'];
        $dass2->skor_stres = $scores2['skor_stres'];
        $dass2->total_skor = $scores2['total_skor'];
        $dass2->kategori_depresi = $scores2['kategori_depresi'];
        $dass2->kategori_kecemasan = $scores2['kategori_kecemasan'];
        $dass2->kategori_stres = $scores2['kategori_stres'];
        $dass2->detail_jawaban = $responses2;
        $dass2->created_at = Carbon::now()->subDays(2)->setHour(16)->setMinute(15);
        $dass2->save();

        $this->command->info("Seeding data dummy mood berhasil diselesaikan!");
    }
}
