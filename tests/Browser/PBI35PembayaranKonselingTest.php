<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI35PembayaranKonselingTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 35: Pembayaran konseling menyimpan metode pembayaran dan status yang benar.
     */
    public function test_menampilkan_dan_menyimpan_metode_pembayaran_konseling()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create([
                'harga_per_sesi' => 120000,
            ]);

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000)
                    ->assertSee('Metode Pembayaran')
                    ->assertSee('Transfer Bank')
                    ->assertSee('E-Wallet')
                    ->assertDontSee('Kartu Kredit');

            $browser->script([
                'document.getElementById("jadwal-picker").value = "2026-05-10 10:00";',
                'document.getElementById("jadwal-picker").dispatchEvent(new Event("change", { bubbles: true }));'
            ]);

            $browser->click('input[name="media_konseling"][value="video_call"] + div')
                    ->click('label[for="payment_method_transfer"]')
                    ->type('deskripsi', 'Tes pembayaran dengan metode transfer')
                    ->pause(500)
                    ->press('Konfirmasi Pembayaran')
                    ->pause(1000)
                    ->waitForText('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.', 10)
                    ->assertSee('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.');

            $this->assertDatabaseHas('sesi_konselings', [
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'media_konseling' => 'video_call',
                'payment_method' => 'transfer',
                'payment_status' => 'paid',
                'status' => 'pending',
            ]);
        });
    }
}
