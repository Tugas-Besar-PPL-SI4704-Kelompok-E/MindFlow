<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI59MemilihTipeKonselingTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 59: Memilih tipe konseling (Video Call, Voice Call, Chat)
     */
    public function test_memilih_media_konseling_chat()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000);

            // Set jadwal value dan dispatch change event agar form mengirim nilainya
            $browser->script([
                'document.getElementById("jadwal-picker").value = "2026-06-15 14:00";',
                'document.getElementById("jadwal-picker").dispatchEvent(new Event("change", { bubbles: true }));'
            ]);
            
            // Memilih media konseling 'chat'
            $browser->click('input[name="media_konseling"][value="chat"] + div')
                    ->type('deskripsi', 'Saya ingin konseling lewat chat karena lebih nyaman')
                    ->pause(500);

            $browser->press('Konfirmasi Reservasi')
                    ->pause(500)
                    ->waitForText('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.', 10)
                    ->assertSee('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.');
            
            // Memastikan data tersimpan di database dengan media_konseling yang benar
            $this->assertDatabaseHas('sesi_konselings', [
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => '2026-06-15 14:00',
                'media_konseling' => 'chat',
                'status' => 'pending'
            ]);
        });
    }
}
