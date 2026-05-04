<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI29PemesananKonselorTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 29: Logika dan alur pemesanan konselor
     */
    public function test_menyimpan_data_pemesanan_sesi_konseling_ke_database()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();

            $browser->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->type('jadwal', '2026-05-10T10:00')
                    ->press('Konfirmasi Reservasi')
                    ->assertSee('Reservasi berhasil dibuat!');
            
            $this->assertDatabaseHas('sesi_konselings', [
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => '2026-05-10 10:00:00',
                'status' => 'pending'
            ]);
        });
    }
}
