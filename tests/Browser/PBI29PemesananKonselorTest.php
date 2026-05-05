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

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000);

            // Set jadwal value dan dispatch change event agar form mengirim nilainya
            $browser->script([
                'document.getElementById("jadwal-picker").value = "2026-05-10 10:00";',
                'document.getElementById("jadwal-picker").dispatchEvent(new Event("change", { bubbles: true }));'
            ]);
            $browser->type('deskripsi', 'Topik konsultasi mengenai stres akademik')
                    ->pause(500);

            $browser->press('Konfirmasi Reservasi')
                    ->pause(500)
                    ->waitForText('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.', 10)
                    ->assertSee('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.');
            
            $this->assertDatabaseHas('sesi_konselings', [
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => '2026-05-10 10:00',
                'status' => 'pending'
            ]);
        });
    }
}
