<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\CounselorSchedule;
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

            // Create counselor schedules for next 30 days
            $dayNames = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
            foreach ($dayNames as $day) {
                CounselorSchedule::create([
                    'profil_konselor_id' => $konselor->profil_konselor_id,
                    'hari' => $day,
                    'jam_mulai' => '09:00',
                    'jam_selesai' => '17:00',
                    'is_active' => true
                ]);
            }

            $jadwal = Carbon::now()->addDays(2)->startOfHour()->format('Y-m-d H:i');

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(2000)
                    ->waitForText('Booking Sesi', 5)
                    ->assertSee('Transfer Bank')
                    ->assertSee('E-Wallet')
                    ->assertDontSee('Kartu Kredit');

            // Set the select value directly using JavaScript and trigger events
            $browser->script([
                'const select = document.querySelector("select[name=\"jadwal\"]"); 
                if (select && select.options.length > 1) { 
                    select.value = select.options[1].value;
                    select.dispatchEvent(new Event("change", { bubbles: true }));
                    // Trigger Choices.js update
                    if (window.Choices && window.choicesInstances) {
                        const instance = Object.values(window.choicesInstances).find(c => c._element === select);
                        if (instance) instance._triggerChange(select.value);
                    }
                }'
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
