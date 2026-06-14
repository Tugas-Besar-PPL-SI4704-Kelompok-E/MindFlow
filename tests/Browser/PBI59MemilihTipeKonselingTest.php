<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\CounselorSchedule;
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
                    ->pause(2000);

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
                    ->pause(1000);
            
            $browser->waitForText('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.', 10)
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
