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

    /**
     * PBI 30: TC Notifikasi 001
     * Pre Condition:
     * - User sudah login
     * - Halaman detail konselor dapat diakses
     * - Form reservasi tersedia
     * 
     * Test Scenario: Menampilkan notifikasi sukses setelah reservasi
     */
    public function test_menampilkan_notifikasi_sukses_setelah_reservasi()
    {
        $this->browse(function (Browser $browser) {
            // Setup: Create user dan konselor
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();

            // Pre Condition: User login dan visit halaman konselor
            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000) // Wait untuk page load
                    ->screenshot('pre-condition');

            // Steps: Set date value dan deskripsi pesan
            $browser->script([
                'document.getElementById("jadwal-picker").value = "2026-05-10 10:00";',
                'document.getElementById("jadwal-picker").dispatchEvent(new Event("change", { bubbles: true }));',
                'document.querySelector("input[name=\"media_konseling\"][value=\"chat\"]").checked = true;'
            ]);
            $browser->assertChecked('input[name="media_konseling"][value="chat"]')
                    ->type('deskripsi', 'Topik konsultasi mengenai stres akademik')
                    ->pause(500)
                    ->screenshot('step-1');

            // Submit form
            $browser->press('Konfirmasi Reservasi')
                    ->pause(500)
                    ->waitForText('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.', 10)
                    ->screenshot('step-2');

            // Expected Result: Notifikasi sukses muncul
            $browser->assertSee('Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.')
                    ->screenshot('result');
        });
    }

    /**
     * PBI 30: TC Notifikasi 002
     * Pre Condition:
     * - User sudah login
     * - Sesi konseling sudah terbuat dengan status pending
     * - Halaman edit booking dapat diakses
     * 
     * Test Scenario: Menampilkan notifikasi info setelah perubahan jadwal
     */
    public function test_menampilkan_notifikasi_info_setelah_perubahan_jadwal()
    {
        $this->browse(function (Browser $browser) {
            // Setup: Create user, konselor, dan sesi
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'status' => 'pending'
            ]);

            // Pre Condition: User login dan visit halaman edit booking
            $browser->loginAs($user)
                    ->visit("/booking/edit/{$sesi->sesi_konseling_id}")
                    ->pause(1500) // Wait untuk page load
                    ->screenshot('pre-condition');

            // Steps: Update jadwal field dengan wait untuk element muncul
            $browser->waitFor('input[name="jadwal"]', 5)
                    ->type('input[name="jadwal"]', '2026-05-11T14:00')
                    ->pause(500)
                    ->screenshot('step-1');

            // Submit form
            $browser->press('Kirim Pengajuan')
                    ->pause(500)
                    ->waitForText('Pengajuan perubahan jadwal berhasil dikirim! Menunggu konfirmasi konselor.', 10)
                    ->screenshot('step-2');

            // Expected Result: Notifikasi perubahan jadwal muncul
            $browser->assertSee('Pengajuan perubahan jadwal berhasil dikirim! Menunggu konfirmasi konselor.')
                    ->screenshot('result');
        });
    }

    /**
     * PBI 30: TC Notifikasi 003
     * Pre Condition:
     * - User sudah login
     * - Sesi konseling sudah terbuat dengan status pending
     * - User berada di halaman dengan opsi pembatalan
     * 
     * Test Scenario: Menampilkan notifikasi error setelah pembatalan
     */
    public function test_menampilkan_notifikasi_error_setelah_pembatalan()
    {
        $this->browse(function (Browser $browser) {
            // Setup: Create user, konselor, dan sesi
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'status' => 'pending'
            ]);

            // Pre Condition: User login dan visit halaman konselor
            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->pause(1000) // Wait 1 second for page to load
                    ->screenshot('pre-condition');

            // Steps: Klik button batalkan sesi dan confirm dialog
            $browser->press('Batalkan Sesi')
                    ->acceptDialog()
                    ->pause(500)
                    ->waitForText('Sesi konsultasi Anda telah dibatalkan.', 10)
                    ->screenshot('step-1');

            // Expected Result: Notifikasi pembatalan muncul
            $browser->assertSee('Sesi konsultasi Anda telah dibatalkan.')
                    ->screenshot('result');
        });
    }
}
