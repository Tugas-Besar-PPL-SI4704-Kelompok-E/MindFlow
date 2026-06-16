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

        
        CounselorSchedule::firstOrCreate(
            ['profil_konselor_id' => $profil->profil_konselor_id, 'hari' => 'senin'],
            [
                'jam_mulai'   => '09:00',
                'jam_selesai' => '17:00',
            ]
        );

        
        Journal::create([
            'user_id' => $userWithJournal->id,
            'content' => 'Hari ini saya merasa cemas tentang ujian semester.',
        ]);
        Journal::create([
            'user_id' => $userWithJournal->id,
            'content' => 'Saya bersyukur karena teman-teman yang mendukung saya.',
        ]);
    }

    


    public function testLampiranJurnalDenganData(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/konseling')
                 ->pause(1000)
                 ->assertSee('Pilih Konselor')
                 
                 ->clickLink('Pilih Sesi')
                 ->pause(1000)
                 ->assertSee('Booking Sesi')
                 
                 ->script("document.querySelector('#journals')?.closest('.space-y-2')?.scrollIntoView();");

            $browser->pause(500)
                 
                 ->assertPresent('#journals')
                 
                 ->click('.choices__inner')
                 ->pause(500)
                 
                 ->script("
                    let items = document.querySelectorAll('.choices__list--dropdown .choices__item--selectable');
                    if(items.length >= 1) {
                        items[0].click();
                    }
                 ");

            $browser->pause(300)
                 ->click('.choices__inner')
                 ->pause(300)
                 
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

    


    public function testBacaJurnalDiRuangKonseling(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        $konselor = User::where('email', 'konselor@example.com')->first();
        $profil = ProfilKonselor::where('user_id', $konselor->id)->first();

        
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

        
        $journals = Journal::where('user_id', $user->id)->pluck('journal_id');
        $sesi->journals()->attach($journals);

        
        $this->browse(function (Browser $browser) use ($konselor, $sesi) {
            $browser->loginAs($konselor)
                 ->visit('/sesi-konseling/' . $sesi->sesi_konseling_id . '/room')
                 ->pause(1500)
                 ->assertSee('Lihat Jurnal')
                 
                 ->click('button[onclick*="journal-modal"]')
                 ->pause(500)
                 ->assertVisible('#journal-modal')
                 ->assertSee('Jurnal Pasien')
                 
                 ->click('#journal-modal button[onclick*="hidden"]')
                 ->pause(500)
                 ->screenshot('TC_LampiranJurnal_003_Pass');
        });
    }
}
