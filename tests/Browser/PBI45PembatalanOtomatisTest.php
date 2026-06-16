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

    




    public function test_pembatalan_otomatis_sesi_kadaluarsa_menampilkan_modal_notifikasi()
    {
        $this->browse(function (Browser $browser) {
            
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create(['nama' => 'Dr. Riana Ar-Zahra']);
            
            
            $sesi = SesiKonseling::factory()->create([
                'user_id' => $user->id,
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => now()->subHours(2), 
                'status' => 'pending'
            ]);

            
            $browser->loginAs($user)
                    ->visit('/home')
                    ->pause(1500) 
                    ->screenshot('pbi45-pembatalan-otomatis-modal');

            
            $browser->assertPresent('#expiredCancellationModal')
                    ->assertSee('Pembatalan Otomatis')
                    ->assertSee('Sesi konseling Anda telah dibatalkan secara otomatis')
                    ->assertSee('Dr. Riana Ar-Zahra')
                    ->screenshot('pbi45-modal-detail');

            
            $browser->press('#btn-mengerti-pembatalan')
                    ->pause(500)
                    ->assertNotPresent('#expiredCancellationModal')
                    ->screenshot('pbi45-modal-closed');
        });
    }
}
