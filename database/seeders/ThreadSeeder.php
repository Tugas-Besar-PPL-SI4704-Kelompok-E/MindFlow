<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Thread;
use App\Models\ThreadReply;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users
        $asep = User::where('email', 'asep@example.com')->first();
        $rania = User::where('email', 'rania@example.com')->first();
        $budi = User::where('email', 'budi@example.com')->first();
        $admin = User::where('email', 'admin@mindflow.id')->first();

        // Fallbacks if not found (create them or use first user)
        if (!$asep) {
            $asep = User::firstOrCreate(
                ['email' => 'asep@example.com'],
                [
                    'nama_asli' => 'Asep',
                    'nama_samaran' => 'Asep',
                    'password' => bcrypt('password'),
                    'role' => 'user',
                    'status' => 'approved'
                ]
            );
        }
        if (!$rania) {
            $rania = User::firstOrCreate(
                ['email' => 'rania@example.com'],
                [
                    'nama_asli' => 'Rania Ar-Zahra',
                    'nama_samaran' => 'Rania',
                    'password' => bcrypt('password'),
                    'role' => 'konselor',
                    'status' => 'approved'
                ]
            );
        }
        if (!$budi) {
            $budi = User::firstOrCreate(
                ['email' => 'budi@example.com'],
                [
                    'nama_asli' => 'Budi Rahardjo',
                    'nama_samaran' => 'Budi',
                    'password' => bcrypt('password'),
                    'role' => 'konselor',
                    'status' => 'approved'
                ]
            );
        }
        if (!$admin) {
            $admin = User::firstOrCreate(
                ['email' => 'admin@mindflow.id'],
                [
                    'nama_asli' => 'Admin MindFlow',
                    'nama_samaran' => 'Admin',
                    'password' => bcrypt('admin123'),
                    'role' => 'admin',
                ]
            );
        }

        // Create thread 1 (Asep - Anonymous)
        $thread1 = Thread::create([
            'user_id' => $asep->id,
            'content' => "Halo semua, belakangan ini saya merasa sangat cemas kalau mau menghadapi ujian akhir semester. Rasanya seperti blank setiap kali melihat lembar soal. Ada yang punya tips untuk mengatasi kecemasan seperti ini?",
            'is_anonymous' => true,
        ]);

        // Create replies for thread 1
        $reply1 = ThreadReply::create([
            'user_id' => $rania->id, // counselor
            'thread_id' => $thread1->id,
            'content' => "Halo! Wajar sekali merasa cemas. Salah satu teknik instan yang bisa dicoba adalah teknik pernapasan 4-7-8 sebelum memulai ujian. Tarik napas 4 detik, tahan 7 detik, embuskan 8 detik. Ini membantu menenangkan sistem saraf.",
        ]);

        $reply2 = ThreadReply::create([
            'user_id' => $asep->id,
            'thread_id' => $thread1->id,
            'parent_id' => $reply1->id, // nested reply
            'content' => "Terima kasih Dokter Rania! Saya akan mencoba mempraktikkannya besok pagi.",
        ]);

        $reply3 = ThreadReply::create([
            'user_id' => $budi->id, // counselor
            'thread_id' => $thread1->id,
            'content' => "Betul kata Dokter Rania. Selain itu, cobalah untuk tidak belajar dengan sistem kebut semalam. Persiapan yang dicicil jauh-jauh hari akan memberi rasa kendali yang lebih besar, sehingga menurunkan tingkat kecemasan.",
        ]);

        // Create thread 2 (Rania - Public)
        $thread2 = Thread::create([
            'user_id' => $rania->id,
            'content' => "Self-care bukan berarti kita egois. Menjaga kesehatan mental diri sendiri adalah langkah awal agar kita bisa membantu orang lain dengan lebih baik. Apa bentuk self-care favoritmu minggu ini? 💜",
            'is_anonymous' => false,
        ]);

        $reply4 = ThreadReply::create([
            'user_id' => $asep->id,
            'thread_id' => $thread2->id,
            'content' => "Minggu ini self-care saya adalah mematikan notifikasi HP selama satu hari penuh di hari Minggu. Rasanya sangat damai!",
        ]);

        // Create thread 3 (Admin - Public)
        $thread3 = Thread::create([
            'user_id' => $admin->id,
            'content' => "Selamat datang di Forum MindFlow! Tempat yang aman dan suportif bagi siapa saja untuk berbagi cerita tentang kesehatan mental. Mari saling mendukung dan menjaga bahasa kita agar tetap santun ya. 😊",
            'is_anonymous' => false,
        ]);

        // Seed some likes and saves using relationships
        // Asep likes admin's post
        $thread3->likes()->attach($asep->id);
        // Counselor likes Asep's post
        $thread1->likes()->attach($rania->id);
        $thread1->likes()->attach($budi->id);
        // Asep saves counselor's post
        $thread2->saves()->attach($asep->id);
    }
}
