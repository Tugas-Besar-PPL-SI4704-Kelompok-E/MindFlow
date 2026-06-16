<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI30NotifikasiTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_menampilkan_notifikasi_sukses_setelah_reservasi()
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
                    ->pause(1000)
                    ->screenshot('pre-condition');

            $browser->script("
                var select = document.getElementById('jadwal-select');
                if (select) {
                    var opt = document.createElement('option');
                    opt.value = '" . $bookingDate . "';
                    opt.textContent = '" . $bookingDate . "';
                    select.appendChild(opt);
                    select.value = '" . $bookingDate . "';
                }
                var mediaInput = document.querySelector('input[name=\"media_konseling\"][value=\"chat\"]');
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
        });
    }

    public function test_menampilkan_notifikasi_info_setelah_perubahan_jadwal()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'status' => 'pending',
                'jadwal' => \Carbon\Carbon::now()->addDays(2)->format('Y-m-d H:i'),
            ]);

            $browser->loginAs($user)
                    ->visit("/booking/edit/{$sesi->sesi_konseling_id}")
                    ->pause(1500)
                    ->screenshot('pre-condition');

            $newJadwal = now()->addDays(6)->format('Y-m-d\TH:i');

            $browser->waitFor('input[name="jadwal"]', 5);
            $browser->script([
                "let input = document.querySelector('input[name=\"jadwal\"]');
                 input.value = '{$newJadwal}';
                 input.dispatchEvent(new Event('change', { bubbles: true }));"
            ]);
            $browser->pause(500)
                    ->screenshot('step-1');

            $browser->press('Kirim Pengajuan')
                    ->pause(500)
                    ->waitForText('Pengajuan perubahan jadwal berhasil dikirim! Menunggu konfirmasi konselor.', 10)
                    ->screenshot('step-2');

            $browser->assertSee('Pengajuan perubahan jadwal berhasil dikirim! Menunggu konfirmasi konselor.')
                    ->screenshot('result');
        });
    }

    public function test_menampilkan_notifikasi_error_setelah_pembatalan()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'status' => 'pending'
            ]);

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000)
                    ->screenshot('pre-condition');

            $browser->press('Batalkan Sesi')
                    ->acceptDialog()
                    ->pause(500)
                    ->waitForText('Jadwal konsultasi berhasil dibatalkan.', 10)
                    ->screenshot('step-1');

            $browser->assertSee('Jadwal konsultasi berhasil dibatalkan.')
                    ->screenshot('result');
        });
    }
}
