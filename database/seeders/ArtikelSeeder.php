<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    /**
     * Seed sample artikel untuk testing.
     */
    public function run(): void
    {
        // Ambil admin user sebagai author
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->warn('Admin user not found. Please run AdminSeeder first.');
            return;
        }

        $artikels = [
            [
                'judul' => 'Mengenal Kesehatan Mental: Mengapa Itu Penting?',
                'konten' => "Kesehatan mental adalah aspek penting dari kesejahteraan kita secara keseluruhan. Sama seperti kesehatan fisik, kesehatan mental mempengaruhi cara kita berpikir, merasa, dan bertindak dalam kehidupan sehari-hari.\n\nMenurut WHO, kesehatan mental adalah kondisi kesejahteraan di mana individu menyadari potensinya sendiri, dapat mengatasi tekanan hidup yang normal, dapat bekerja secara produktif, dan mampu memberikan kontribusi kepada komunitasnya.\n\nBeberapa tanda bahwa kesehatan mental Anda perlu diperhatikan:\n\n1. Perubahan pola tidur yang drastis\n2. Kehilangan minat pada aktivitas yang biasa dinikmati\n3. Perasaan cemas atau khawatir yang berlebihan\n4. Perubahan nafsu makan yang signifikan\n5. Kesulitan berkonsentrasi\n\nPenting untuk diingat bahwa mencari bantuan profesional bukanlah tanda kelemahan, melainkan langkah berani menuju pemulihan. Konseling dan terapi telah terbukti efektif dalam membantu banyak orang mengatasi tantangan kesehatan mental mereka.\n\nMulailah dengan langkah kecil: bicarakan perasaan Anda dengan seseorang yang Anda percaya, jaga pola hidup sehat, dan jangan ragu untuk mencari bantuan profesional jika diperlukan.",
                'kategori' => 'Kesehatan Mental',
                'gambar_cover' => null,
            ],
            [
                'judul' => '5 Teknik Mindfulness untuk Mengurangi Stres',
                'konten' => "Stres adalah bagian tak terhindarkan dari kehidupan modern. Namun, dengan teknik mindfulness yang tepat, kita bisa mengelolanya dengan lebih baik.\n\n**1. Pernapasan Dalam (Deep Breathing)**\nDuduklah dengan nyaman, tutup mata, dan fokuskan perhatian pada napas Anda. Tarik napas dalam selama 4 detik, tahan selama 7 detik, dan hembuskan selama 8 detik. Ulangi 4-5 kali.\n\n**2. Body Scan Meditation**\nBerbaring atau duduk dengan nyaman. Mulai dari ujung kaki, perhatikan sensasi di setiap bagian tubuh Anda secara perlahan ke atas hingga ke kepala. Ini membantu melepaskan ketegangan fisik.\n\n**3. Mindful Walking**\nSaat berjalan, fokuskan perhatian pada setiap langkah. Rasakan kaki Anda menyentuh tanah, perhatikan gerakan tubuh, dan nikmati lingkungan sekitar tanpa menghakimi.\n\n**4. Journaling**\nLuangkan 10 menit setiap hari untuk menulis pikiran dan perasaan Anda. Tidak perlu terstruktur — cukup tuangkan apa yang ada di pikiran. Ini membantu memproses emosi dan mendapatkan kejelasan.\n\n**5. Gratitude Practice**\nSetiap malam sebelum tidur, tuliskan 3 hal yang Anda syukuri hari itu. Praktik sederhana ini telah terbukti secara ilmiah meningkatkan kebahagiaan dan mengurangi stres.\n\nKonsistensi adalah kunci. Mulailah dengan 5 menit sehari dan tingkatkan secara bertahap.",
                'kategori' => 'Tips & Trik',
                'gambar_cover' => null,
            ],
            [
                'judul' => 'Memahami Anxiety: Kapan Cemas Menjadi Gangguan?',
                'konten' => "Kecemasan adalah respons alami tubuh terhadap stres. Namun, kapan kecemasan biasa berubah menjadi gangguan kecemasan (anxiety disorder)?\n\n**Kecemasan Normal vs Gangguan Kecemasan**\n\nKecemasan normal biasanya:\n- Terkait dengan situasi spesifik\n- Bersifat sementara\n- Tidak mengganggu aktivitas sehari-hari\n- Proporsional terhadap situasi yang dihadapi\n\nGangguan kecemasan ditandai dengan:\n- Kecemasan yang berlebihan dan tidak proporsional\n- Berlangsung selama 6 bulan atau lebih\n- Mengganggu pekerjaan, sekolah, atau hubungan sosial\n- Disertai gejala fisik seperti jantung berdebar, berkeringat, atau gemetar\n\n**Jenis-jenis Gangguan Kecemasan:**\n\n1. Generalized Anxiety Disorder (GAD)\n2. Social Anxiety Disorder\n3. Panic Disorder\n4. Specific Phobias\n5. Separation Anxiety Disorder\n\n**Apa yang Bisa Dilakukan?**\n\nJika Anda merasa kecemasan mulai mengganggu kehidupan sehari-hari, langkah pertama adalah berkonsultasi dengan profesional kesehatan mental. Terapi Cognitive Behavioral Therapy (CBT) telah terbukti sangat efektif dalam mengatasi gangguan kecemasan.\n\nIngat: Anda tidak sendirian, dan bantuan selalu tersedia.",
                'kategori' => 'Edukasi',
                'gambar_cover' => null,
            ],
            [
                'judul' => 'Kekuatan Kata-kata: Bagaimana Self-talk Mempengaruhi Kesehatan Mental',
                'konten' => "Pernahkah Anda memperhatikan bagaimana Anda berbicara kepada diri sendiri? Self-talk atau dialog internal kita memiliki pengaruh besar terhadap kesehatan mental dan kesejahteraan kita.\n\n**Negative Self-talk yang Perlu Diwaspadai:**\n\n- \"Saya tidak cukup baik\" → Filtering: hanya fokus pada kekurangan\n- \"Ini pasti salah saya\" → Personalizing: menyalahkan diri sendiri\n- \"Semuanya selalu buruk\" → Catastrophizing: memperbesar masalah\n- \"Saya pasti gagal\" → Polarizing: berpikir hitam-putih\n\n**Cara Mengubah Negative Self-talk:**\n\n1. **Kenali polanya** — Mulailah memperhatikan kapan Anda berpikir negatif tentang diri sendiri\n2. **Tantang pikiran tersebut** — Tanyakan: \"Apakah ini benar? Apakah ada buktinya?\"\n3. **Ganti dengan alternatif yang realistis** — Bukan positif berlebihan, tapi realistis dan compassionate\n4. **Praktikkan self-compassion** — Perlakukan diri Anda seperti Anda memperlakukan sahabat terbaik\n\n**Contoh Reframing:**\n- Dari: \"Saya gagal\" → Menjadi: \"Saya sedang belajar dan berkembang\"\n- Dari: \"Saya tidak bisa\" → Menjadi: \"Saya belum bisa, tapi saya bisa belajar\"\n- Dari: \"Saya lemah\" → Menjadi: \"Saya sedang melewati masa sulit, dan itu wajar\"\n\nPerubahan self-talk membutuhkan waktu dan latihan. Bersabarlah dengan diri sendiri dalam proses ini.",
                'kategori' => 'Motivasi',
                'gambar_cover' => null,
            ],
            [
                'judul' => 'Panduan Lengkap: Cara Memulai Jurnal untuk Kesehatan Mental',
                'konten' => "Journaling atau menulis jurnal adalah salah satu alat paling sederhana namun paling efektif untuk menjaga kesehatan mental. Berikut panduan lengkap untuk memulai.\n\n**Mengapa Journaling Efektif?**\n\nPenelitian menunjukkan bahwa expressive writing dapat:\n- Mengurangi gejala kecemasan dan depresi\n- Meningkatkan fungsi kekebalan tubuh\n- Membantu memproses trauma\n- Meningkatkan kesadaran diri (self-awareness)\n- Memperbaiki kualitas tidur\n\n**Jenis-jenis Jurnal:**\n\n1. **Gratitude Journal** — Menulis hal-hal yang disyukuri\n2. **Mood Journal** — Mencatat perubahan suasana hati\n3. **Stream of Consciousness** — Menulis apa saja yang terlintas di pikiran\n4. **Prompt-based Journal** — Menulis berdasarkan pertanyaan panduan\n5. **Bullet Journal** — Kombinasi to-do list dan refleksi\n\n**Tips Memulai:**\n\n- Mulai dengan 5 menit sehari\n- Tidak ada aturan benar atau salah\n- Jangan khawatir tentang tata bahasa atau ejaan\n- Temukan waktu yang konsisten (pagi atau malam)\n- Gunakan media yang nyaman (buku fisik atau digital)\n\n**Prompt untuk Pemula:**\n- Apa yang saya rasakan hari ini dan mengapa?\n- Apa satu hal baik yang terjadi hari ini?\n- Apa yang membuat saya khawatir saat ini?\n- Apa yang saya pelajari tentang diri saya minggu ini?\n\nIngat, jurnal adalah ruang aman Anda. Tidak ada yang akan menilai apa yang Anda tulis. Mulailah hari ini!",
                'kategori' => 'Tips & Trik',
                'gambar_cover' => null,
            ],
            [
                'judul' => 'Mengatasi Burnout: Tanda-tanda dan Cara Pemulihannya',
                'konten' => "Burnout adalah kondisi kelelahan emosional, mental, dan fisik yang disebabkan oleh stres berkepanjangan. Apakah Anda mengalaminya?\n\n**3 Dimensi Burnout (menurut Maslach):**\n\n1. **Exhaustion** — Merasa kehabisan energi secara emosional dan fisik\n2. **Cynicism** — Sikap negatif dan detachment terhadap pekerjaan/studi\n3. **Reduced Efficacy** — Merasa tidak kompeten dan tidak produktif\n\n**Tanda-tanda Burnout pada Mahasiswa:**\n\n- Kehilangan motivasi belajar\n- Sering merasa overwhelmed\n- Prokrastinasi yang meningkat\n- Isolasi dari teman dan aktivitas sosial\n- Gangguan tidur dan makan\n- Sakit kepala atau nyeri tubuh tanpa sebab jelas\n- Mudah marah atau menangis\n\n**Langkah Pemulihan:**\n\n1. **Akui kondisi Anda** — Menyadari bahwa Anda mengalami burnout adalah langkah pertama\n2. **Set boundaries** — Belajar mengatakan \"tidak\" dan batasi beban\n3. **Prioritaskan istirahat** — Tidur cukup, ambil jeda, dan berikan waktu untuk diri sendiri\n4. **Reconnect** — Hubungi teman atau keluarga untuk dukungan sosial\n5. **Gerakkan tubuh** — Olahraga ringan seperti jalan kaki atau yoga\n6. **Cari bantuan profesional** — Konselor dapat membantu Anda mengembangkan strategi coping\n\nBurnout bukan berarti Anda lemah. Ini adalah sinyal bahwa tubuh dan pikiran Anda membutuhkan perhatian. Dengarkan sinyal itu.",
                'kategori' => 'Kesehatan Mental',
                'gambar_cover' => null,
            ],
            [
                'judul' => 'Digital Detox: Dampak Media Sosial terhadap Kesehatan Mental',
                'konten' => "Di era digital, media sosial telah menjadi bagian tak terpisahkan dari kehidupan kita. Namun, penelitian menunjukkan hubungan antara penggunaan media sosial berlebihan dengan masalah kesehatan mental.\n\n**Dampak Negatif Media Sosial:**\n\n- **Social Comparison** — Membandingkan diri dengan highlight reel orang lain\n- **FOMO (Fear of Missing Out)** — Kecemasan karena merasa tertinggal\n- **Cyberbullying** — Perundungan online yang berdampak psikologis\n- **Sleep Disruption** — Scrolling sebelum tidur mengganggu kualitas tidur\n- **Addiction Loop** — Dopamine hit dari likes dan notifikasi\n\n**Tanda Anda Perlu Digital Detox:**\n\n- Hal pertama dan terakhir yang Anda lakukan adalah mengecek media sosial\n- Merasa cemas saat tidak bisa akses internet\n- Membandingkan diri sendiri dengan orang lain secara terus-menerus\n- Screen time lebih dari 4 jam/hari untuk non-produktif\n\n**Cara Melakukan Digital Detox:**\n\n1. **Mulai bertahap** — Kurangi 30 menit screen time per minggu\n2. **No-phone zones** — Kamar tidur dan meja makan bebas gadget\n3. **Matikan notifikasi** — Hanya aktifkan notifikasi yang penting\n4. **Schedule social media time** — Tentukan waktu khusus untuk scrolling\n5. **Replace with offline activities** — Baca buku, olahraga, atau bertemu teman langsung\n6. **Unfollow/mute** — Bersihkan feed dari konten yang membuat Anda tidak nyaman\n\nTeknologi seharusnya melayani kita, bukan sebaliknya. Ambil kembali kendali Anda.",
                'kategori' => 'Edukasi',
                'gambar_cover' => null,
            ],
            [
                'judul' => 'Kamu Lebih Kuat dari yang Kamu Kira: Membangun Resiliensi Mental',
                'konten' => "Resiliensi mental adalah kemampuan untuk bangkit kembali dari kesulitan, beradaptasi dengan perubahan, dan terus maju meskipun menghadapi tantangan. Kabar baiknya? Resiliensi bisa dilatih.\n\n**Apa Itu Resiliensi?**\n\nResiliensi bukan berarti tidak pernah merasa sakit atau tidak pernah mengalami kesulitan. Resiliensi adalah kemampuan untuk menavigasi melalui masa-masa sulit dan tumbuh karenanya.\n\n**Pilar-pilar Resiliensi:**\n\n1. **Connection** — Membangun hubungan yang supportive\n2. **Wellness** — Menjaga kesehatan fisik dan mental\n3. **Healthy Thinking** — Mengembangkan perspektif yang seimbang\n4. **Meaning** — Menemukan tujuan dan makna hidup\n\n**Cara Membangun Resiliensi:**\n\n- **Terima bahwa perubahan adalah bagian dari hidup** — Fokuskan energi pada hal-hal yang bisa Anda kontrol\n- **Kembangkan growth mindset** — Lihat tantangan sebagai kesempatan untuk belajar\n- **Jaga hubungan sosial** — Dukungan sosial adalah faktor protektif terkuat\n- **Praktikkan self-care** — Istirahat cukup, makan sehat, dan berolahraga\n- **Set achievable goals** — Pecah target besar menjadi langkah-langkah kecil\n- **Bangun self-awareness** — Kenali emosi dan kebutuhan Anda\n\n**Affirmasi untuk Hari Ini:**\n\n\"Saya sedang dalam proses. Saya boleh istirahat, tapi saya tidak akan menyerah. Setiap langkah kecil adalah kemajuan.\"\n\nPercayalah pada kekuatan dalam diri Anda. Anda telah melewati 100% hari-hari tersulit Anda sejauh ini.",
                'kategori' => 'Motivasi',
                'gambar_cover' => null,
            ],
        ];

        foreach ($artikels as $artikel) {
            Artikel::updateOrCreate(
                ['judul' => $artikel['judul']],
                array_merge($artikel, [
                    'admin_id' => $admin->id,
                    'status' => 'published',
                ])
            );
        }

        $this->command->info('ArtikelSeeder: ' . count($artikels) . ' artikel berhasil di-seed.');
    }
}
