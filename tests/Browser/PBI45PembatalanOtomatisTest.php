<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI45PembatalanOtomatisTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI-45: Pembatalan Otomatis Sesi Kadaluarsa
     * 
     * Test Scenario: Menampilkan modal pembatalan otomatis jika user memiliki sesi pending yang kadaluarsa
     */
    public function test_pembatalan_otomatis_sesi_kadaluarsa_menampilkan_modal_notifikasi()
    {
        $this->browse(function (Browser $browser) {
            // Setup: Create user, konselor, dan sesi pending yang sudah kadaluarsa (lampau)
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create(['nama' => 'Dr. Riana Ar-Zahra']);
            
            // Jadwal di masa lampau (kadaluarsa)
            $sesi = SesiKonseling::factory()->create([
                'user_id' => $user->id,
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => now()->subHours(2), // 2 jam yang lalu
                'status' => 'pending'
            ]);

            // Login dan kunjungi halaman utama (home)
            $browser->loginAs($user)
                    ->visit('/home')
                    ->pause(1500) // Tunggu page load & modal muncul
                    ->screenshot('pbi45-pembatalan-otomatis-modal');

            // Verifikasi modal pembatalan otomatis muncul dengan detail
            $browser->assertPresent('#expiredCancellationModal')
                    ->assertSee('Pembatalan Otomatis')
                    ->assertSee('Sesi konseling Anda telah dibatalkan secara otomatis')
                    ->assertSee('Dr. Riana Ar-Zahra')
                    ->screenshot('pbi45-modal-detail');

            // Klik tombol 'Mengerti' untuk menutup modal
            $browser->press('#btn-mengerti-pembatalan')
                    ->pause(500)
                    ->assertNotPresent('#expiredCancellationModal')
                    ->screenshot('pbi45-modal-closed');
        });
    }
}
