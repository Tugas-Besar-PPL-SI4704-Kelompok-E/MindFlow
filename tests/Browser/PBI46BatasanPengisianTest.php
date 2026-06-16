<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use App\Models\CounselorSchedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI46BatasanPengisianTest extends DuskTestCase
{
    use DatabaseMigrations;

    


    public function test_pemesanan_sesi_konseling_mendadak_ditolak()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();

            $bookingTime = now()->addHour();
            $indonesianDays = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            $bookingDayName = $indonesianDays[$bookingTime->dayOfWeek];
            
            CounselorSchedule::create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'hari' => $bookingDayName,
                'jam_mulai' => '00:00:00',
                'jam_selesai' => '23:59:59',
                'is_active' => true,
            ]);

            $browser->loginAs($user)
                     ->visit("/konseling/{$konselor->profil_konselor_id}")
                     ->pause(1000)
                     ->assertSee('Konfirmasi Pembayaran')
                     ->screenshot('pbi46-counselor-booking-page');

            $suddenTime = $bookingTime->format('Y-m-d H:i');
            $browser->script([
                "let select = document.getElementById('jadwal-select');
                 if (select) {
                     select.className = '';
                     select.style.display = 'block';
                     select.removeAttribute('tabindex');
                     select.removeAttribute('aria-hidden');
                     select.removeAttribute('data-choice');
                     let wrapper = select.closest('.choices');
                     if (wrapper) {
                         wrapper.parentNode.insertBefore(select, wrapper);
                         wrapper.remove();
                     }
                 }
                 let opt = document.createElement('option');
                 opt.value = '{$suddenTime}';
                 opt.text = 'Mendadak Sesi';
                 select.add(opt);
                 select.value = '{$suddenTime}';
                 select.dispatchEvent(new Event('change', { bubbles: true }));

                 // Select media and payment methods via script to bypass visual element clicks
                 document.querySelector('input[name=\"media_konseling\"][value=\"video_call\"]').checked = true;
                 document.querySelector('input[name=\"payment_method\"][value=\"transfer\"]').checked = true;"
            ]);

            $browser->type('deskripsi', 'Mencoba memesan mendadak')
                    ->press('Konfirmasi Pembayaran')
                    ->pause(1500)
                    ->screenshot('pbi46-booking-mendadak-error');

            
            $browser->assertSee('Jadwal tidak valid. Pemesanan tidak boleh mendadak, silakan pilih jadwal minimal 3 jam dari sekarang.');
            
            $this->assertDatabaseMissing('sesi_konselings', [
                'user_id' => $user->id,
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'status' => 'pending'
            ]);
        });
    }

    


    public function test_pemesanan_sesi_konseling_dengan_jadwal_valid_berhasil()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();

            $bookingTime = now()->addDays(5)->setTime(10, 0, 0);
            $indonesianDays = ['minggu', 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            $bookingDayName = $indonesianDays[$bookingTime->dayOfWeek];
            
            CounselorSchedule::create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'hari' => $bookingDayName,
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '22:00:00',
                'is_active' => true,
            ]);

            $browser->loginAs($user)
                     ->visit("/konseling/{$konselor->profil_konselor_id}")
                     ->pause(1000);

            
            $validTime = $bookingTime->format('Y-m-d H:i');
            $browser->script([
                "let select = document.getElementById('jadwal-select');
                 if (select) {
                     select.className = '';
                     select.style.display = 'block';
                     select.removeAttribute('tabindex');
                     select.removeAttribute('aria-hidden');
                     select.removeAttribute('data-choice');
                     let wrapper = select.closest('.choices');
                     if (wrapper) {
                         wrapper.parentNode.insertBefore(select, wrapper);
                         wrapper.remove();
                     }
                 }
                 let opt = document.createElement('option');
                 opt.value = '{$validTime}';
                 opt.text = 'Valid Sesi';
                 select.add(opt);
                 select.value = '{$validTime}';
                 select.dispatchEvent(new Event('change', { bubbles: true }));

                 // Select media and payment methods via script to bypass visual element clicks
                 document.querySelector('input[name=\"media_konseling\"][value=\"video_call\"]').checked = true;
                 document.querySelector('input[name=\"payment_method\"][value=\"transfer\"]').checked = true;"
            ]);

            $browser->type('deskripsi', 'Pemesanan dengan waktu valid')
                    ->press('Konfirmasi Pembayaran')
                    ->pause(1500)
                    ->screenshot('pbi46-booking-valid-success');

            
            $browser->assertSee('Sesi konsultasi berhasil diajukan. Menunggu persetujuan dari konselor');

            $this->assertDatabaseHas('sesi_konselings', [
                'user_id' => $user->id,
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => $validTime . ':00',
                'status' => 'pending'
            ]);
        });
    }

    


    public function test_perubahan_jadwal_aktif_menjadi_mendadak_ditolak()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'jadwal' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'status' => 'pending'
            ]);

            $browser->loginAs($user)
                    ->visit("/booking/edit/{$sesi->sesi_konseling_id}")
                    ->waitFor('input[name="jadwal"]', 5)
                    ->screenshot('pbi46-edit-page');

            
            $suddenEditTime = now()->addHour()->format('Y-m-d\TH:i');
            $browser->script([
                "let input = document.querySelector('input[name=\"jadwal\"]');
                 input.removeAttribute('min');
                 input.value = '{$suddenEditTime}';
                 input.dispatchEvent(new Event('change', { bubbles: true }));"
            ]);

            $browser->press('Kirim Pengajuan')
                    ->pause(1500)
                    ->screenshot('pbi46-edit-mendadak-error');

            
            $browser->assertSee('Perubahan jadwal tidak valid. Jadwal baru harus minimal 3 jam dari sekarang.');

            
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'status' => 'pending',
                'requested_jadwal' => null
            ]);
        });
    }
}
