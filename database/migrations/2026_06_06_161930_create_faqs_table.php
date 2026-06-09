<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->timestamps();
        });

        // Seed default FAQs
        \Illuminate\Support\Facades\DB::table('faqs')->insert([
            [
                'question' => 'Apa itu MindFlow?',
                'answer' => 'MindFlow adalah platform kesejahteraan mental yang dirancang untuk membantu Anda melacak suasana hati, berlatih mindfulness, dan terhubung dengan konselor profesional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah data dan privasi saya aman?',
                'answer' => 'Tentu saja. Privasi pengguna adalah prioritas utama kami. Kami menggunakan nama samaran (pseudonym) dan enkripsi standar industri untuk melindungi seluruh percakapan dan data pribadi Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara mengubah profil dan nama samaran saya?',
                'answer' => 'Anda dapat pergi ke halaman <a href="/settings" class="text-teal-600 hover:underline">Settings</a>. Di sana Anda dapat memperbarui Nama Asli, Nama Samaran, serta Kata Sandi Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah konseling di MindFlow berbayar?',
                'answer' => 'Kami menyediakan layanan dasar gratis (seperti Jurnal dan Tracker Suasana Hati). Namun untuk konseling secara profesional, kami menerapkan biaya konsultasi yang transparan sesuai dengan tarif masing-masing konselor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara membuat janji konseling?',
                'answer' => 'Kunjungi menu <strong>Konsultasi</strong> di sidebar, lalu klik tombol "Buat Janji". Pilih konselor yang tersedia, tentukan jadwal yang cocok, dan konfirmasi pemesanan Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apa itu Mood Tracker dan bagaimana cara menggunakannya?',
                'answer' => 'Mood Tracker adalah fitur untuk memantau kondisi emosional Anda sehari-hari. Tersedia pemeriksaan singkat (check-in harian) dan pemeriksaan mendalam menggunakan kuesioner DASS-21 untuk evaluasi lebih detail.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
