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

    public function test_menyimpan_data_pemesanan_sesi_konseling_ke_database()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();

            $bookingTime = now()->addDays(5)->setTime(10, 0, 0);
            $bookingDate = $bookingTime->format('Y-m-d H:i');
            $indonesianDays = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            $bookingDayName = $indonesianDays[$bookingTime->dayOfWeek];
            
            \App\Models\CounselorSchedule::create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'hari' => $bookingDayName,
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '22:00:00',
                'is_active' => true,
            ]);

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000);

            $browser->script("
                var select = document.getElementById('jadwal-select');
                if (select) {
                    var opt = document.createElement('option');
                    opt.value = '" . $bookingDate . "';
                    opt.textContent = '" . $bookingDate . "';
                    select.appendChild(opt);
                    select.value = '" . $bookingDate . "';
                }
                var mediaInput = document.querySelector('input[name=\"media_konseling\"][value=\"video_call\"]');
                if (mediaInput) { mediaInput.checked = true; }
                var desc = document.getElementById('deskripsi');
                if (desc) { desc.value = 'Topik konsultasi mengenai stres akademik'; }
                var paymentInput = document.querySelector('input[name=\"payment_method\"][value=\"transfer\"]');
                if (paymentInput) { paymentInput.checked = true; }
                var form = document.querySelector('form[action$=\"/booking/store\"]');
                if (form) { form.submit(); }
            ");

            $browser->pause(2000)
                    ->assertSee('Sesi konsultasi berhasil diajukan. Menunggu persetujuan dari konselor');
            
            $this->assertDatabaseHas('sesi_konselings', [
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => $bookingDate . ':00',
                'media_konseling' => 'video_call',
                'status' => 'pending'
            ]);
        });
    }
}
