<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\ProfilKonselor;
use App\Models\Journal;
use App\Models\CounselorSchedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LampiranJurnalTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // User yang sudah punya jurnal
        $userWithJournal = User::firstOrCreate(
            ['email' => 'asep@example.com'],
            [
                'nama_asli'    => 'Asep',
                'nama_samaran' => 'Asep',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'status'       => 'approved',
            ]
        );

        // User baru tanpa jurnal
        User::firstOrCreate(
            ['email' => 'asepbaru@example.com'],
            [
                'nama_asli'    => 'Asep Baru',
                'nama_samaran' => 'Asep Baru',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'status'       => 'approved',
            ]
        );

        // Buat user konselor
        $konselorUser = User::firstOrCreate(
            ['email' => 'konselor@example.com'],
            [
                'nama_asli'    => 'Dr. Konselor',
                'nama_samaran' => 'Dr. Konselor',
                'password'     => Hash::make('password'),
                'role'         => 'konselor',
                'status'       => 'approved',
            ]
        );

        // Buat profil konselor
        $profil = ProfilKonselor::firstOrCreate(
            ['user_id' => $konselorUser->id],
            [
                'nama'          => 'Dr. Konselor',
                'spesialisasi'  => 'Kecemasan',
                'biografi'      => 'Konselor berpengalaman.',
                'keahlian'      => 'CBT, Mindfulness',
                'harga_per_sesi'=> 100000,
            ]
        );

        // Buat jadwal konselor
        CounselorSchedule::firstOrCreate(
            ['profil_konselor_id' => $profil->profil_konselor_id, 'hari' => 'senin'],
            [
                'jam_mulai'   => '09:00',
                'jam_selesai' => '17:00',
            ]
        );

        // Buat 2 jurnal untuk user Asep
        Journal::create([
            'user_id' => $userWithJournal->id,
            'content' => 'Hari ini saya merasa cemas tentang ujian semester.',
        ]);
        Journal::create([
            'user_id' => $userWithJournal->id,
            'content' => 'Saya bersyukur karena teman-teman yang mendukung saya.',
        ]);
    }

    /**
     * TC.LampiranJurnal.001 - User berhasil membuka dropdown, menyeleksi 2 jurnal
     */
    public function testLampiranJurnalDenganData(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/konseling')
                 ->pause(1000)
                 ->assertSee('Pilih Konselor')
                 // Klik "Pilih Sesi" pada konselor pertama (bukan sidebar link)
                 ->clickLink('Pilih Sesi')
                 ->pause(1000)
                 ->assertSee('Booking Sesi')
                 // Scroll ke bagian jurnal yang ada di bawah form
                 ->script("document.querySelector('#journals')?.closest('.space-y-2')?.scrollIntoView();");

            $browser->pause(500)
                 // Pastikan elemen dropdown jurnal ada di halaman
                 ->assertPresent('#journals')
                 // Klik dropdown Choices.js untuk jurnal
                 ->click('.choices__inner')
                 ->pause(500)
                 // Pilih jurnal pertama dari dropdown
                 ->script("
                    let items = document.querySelectorAll('.choices__list--dropdown .choices__item--selectable');
                    if(items.length >= 1) {
                        items[0].click();
                    }
                 ");

            $browser->pause(300)
                 ->click('.choices__inner')
                 ->pause(300)
                 // Pilih jurnal kedua
                 ->script("
                    let items = document.querySelectorAll('.choices__list--dropdown .choices__item--selectable');
                    if(items.length >= 1) {
                        items[0].click();
                    }
                 ");

            $browser->pause(500)
                 ->screenshot('TC_LampiranJurnal_001_Pass');
        });
    }

    /**
     * TC.LampiranJurnal.002 - Sistem memunculkan info bahwa user belum pernah menulis jurnal
     */
    public function testLampiranJurnalKosong(): void
    {
        $user = User::where('email', 'asepbaru@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/konseling')
                 ->pause(1000)
                 ->assertSee('Pilih Konselor')
                 ->clickLink('Pilih Sesi')
                 ->pause(1000)
                 ->assertSee('Booking Sesi')
                 ->assertSee('Kamu belum pernah menulis jurnal')
                 ->assertSee('Tulis jurnal pertamamu')
                 ->screenshot('TC_LampiranJurnal_002_Pass');
        });
    }

    /**
     * TC.LampiranJurnal.003 - Konselor membaca jurnal di Ruang Konseling via modal
     */
    public function testBacaJurnalDiRuangKonseling(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        $konselor = User::where('email', 'konselor@example.com')->first();
        $profil = ProfilKonselor::where('user_id', $konselor->id)->first();

        // Buat sesi konseling yang confirmed + paid + jadwalnya sekarang agar bisa masuk room
        $sesi = \App\Models\SesiKonseling::create([
            'user_id'            => $user->id,
            'profil_konselor_id' => $profil->profil_konselor_id,
            'jadwal'             => now()->addMinutes(5),
            'media_konseling'    => 'chat',
            'deskripsi'          => 'Saya butuh konsultasi',
            'status'             => 'confirmed',
            'payment_status'     => 'paid',
            'payment_method'     => 'transfer',
            'approved_at'        => now()->subHour(),
        ]);

        // Lampirkan jurnal ke sesi
        $journals = Journal::where('user_id', $user->id)->pluck('journal_id');
        $sesi->journals()->attach($journals);

        // Login sebagai konselor untuk melihat jurnal
        $this->browse(function (Browser $browser) use ($konselor, $sesi) {
            $browser->loginAs($konselor)
                 ->visit('/sesi-konseling/' . $sesi->sesi_konseling_id . '/room')
                 ->pause(1500)
                 ->assertSee('Lihat Jurnal')
                 // Klik tombol Lihat Jurnal
                 ->click('button[onclick*="journal-modal"]')
                 ->pause(500)
                 ->assertVisible('#journal-modal')
                 ->assertSee('Jurnal Pasien')
                 // Klik tombol Tutup
                 ->click('#journal-modal button[onclick*="hidden"]')
                 ->pause(500)
                 ->screenshot('TC_LampiranJurnal_003_Pass');
        });
    }
}
