<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
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

            $jadwal = Carbon::now()->addDays(2)->startOfHour()->format('Y-m-d H:i');

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000)
                    ->waitForText('Booking Sesi', 5)
                    ->assertSee('Transfer Bank')
                    ->assertSee('E-Wallet')
                    ->assertDontSee('Kartu Kredit');

            $browser->script([
                sprintf(
                    'const picker = document.getElementById("jadwal-picker"); if (picker && picker._flatpickr) { picker._flatpickr.setDate("%s", true, "Y-m-d H:i"); } else if (picker) { picker.value = "%s"; picker.dispatchEvent(new Event("input", { bubbles: true })); picker.dispatchEvent(new Event("change", { bubbles: true })); }',
                    $jadwal,
                    $jadwal
                )
            ]);
            $browser->pause(1000);

                $browser->click('input[name="media_konseling"][value="video_call"] + div')
                    ->click('input[name="payment_method"][value="transfer"] + div')
                    ->type('deskripsi', 'Tes pembayaran dengan metode transfer')
                    ->pause(500)
                    ->press('Konfirmasi Pembayaran')
                    ->pause(1000);

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
