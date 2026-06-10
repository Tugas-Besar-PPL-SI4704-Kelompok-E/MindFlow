<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Carbon\Carbon;
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
            $jadwal = Carbon::now()->addDays(2)->startOfHour()->format('Y-m-d H:i');

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000);

            // Set jadwal value dan dispatch change event agar form mengirim nilainya
            $browser->script([
                sprintf('const picker = document.getElementById("jadwal-picker"); if (picker && picker._flatpickr) { picker._flatpickr.setDate("%s", true, "Y-m-d H:i"); } else if (picker) { picker.value = "%s"; picker.dispatchEvent(new Event("change", { bubbles: true })); }', $jadwal, $jadwal)
            ]);
            $browser->pause(1000);
            
            // Memilih media konseling 'chat'
            $browser->click('input[name="media_konseling"][value="chat"] + div')
                    ->click('input[name="payment_method"][value="transfer"] + div')
                    ->pause(500);

            $selectedMedia = $browser->script(['return document.querySelector("input[name=\'media_konseling\']:checked") ? document.querySelector("input[name=\'media_konseling\']:checked").value : null;'])[0] ?? null;
            $selectedPayment = $browser->script(['return document.querySelector("input[name=\'payment_method\']:checked") ? document.querySelector("input[name=\'payment_method\']:checked").value : null;'])[0] ?? null;
            $this->assertSame('chat', $selectedMedia);
            $this->assertSame('transfer', $selectedPayment);

            $browser->type('deskripsi', 'Saya ingin konseling lewat chat karena lebih nyaman')
                    ->pause(500);

            $browser->press('Konfirmasi Pembayaran')
                    ->pause(500)
                    ->waitForText('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.', 10)
                    ->assertSee('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.');

            // Memastikan data tersimpan di database dengan media_konseling yang benar
            $this->assertDatabaseHas('sesi_konselings', [
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'media_konseling' => 'chat',
                'status' => 'pending'
            ]);
        });
    }
}
