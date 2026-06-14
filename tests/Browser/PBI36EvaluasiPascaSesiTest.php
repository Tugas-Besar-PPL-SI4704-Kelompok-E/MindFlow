<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI36EvaluasiPascaSesiTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * TC_Counseling_001: Konselor mengisi catatan evaluasi dengan data valid.
     */
    public function test_konselor_mengisi_catatan_evaluasi_dengan_data_valid()
    {
        $this->browse(function (Browser $browser) {
            // Setup: Create counselor and confirmed session (completed-eligible)
            $konselor = ProfilKonselor::factory()->create();
            $user = User::factory()->create();
            
            // Jadwal 1 jam yang lalu, agar bisaBeriCatatan bernilai true
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'jadwal' => now()->subHours(1)->format('Y-m-d H:i:s'),
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);

            // Login sebagai konselor dan buka halaman jadwal
            $browser->loginAs($konselor->user)
                    ->visit('/konselor/jadwal')
                    ->pause(1000)
                    ->assertSee('Jadwal Konseling')
                    ->assertSee('Beri Catatan')
                    ->screenshot('pbi36-jadwal-counselor');

            // Klik tombol "Beri Catatan" untuk membuka modal
            $browser->press('Beri Catatan')
                    ->pause(500)
                    ->assertPresent("#modal-eval-{$sesi->sesi_konseling_id}")
                    ->screenshot('pbi36-modal-opened');

            // Isi catatan evaluasi
            $browser->type('catatan_konselor', 'Sesi konseling berjalan dengan baik. Pasien menunjukkan tingkat stres akademis yang menurun.')
                    ->press('Simpan & Selesaikan Sesi')
                    ->pause(1000)
                    ->screenshot('pbi36-catatan-tersimpan');

            // Verifikasi status sesi di database
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'status' => 'completed',
                'catatan_konselor' => 'Sesi konseling berjalan dengan baik. Pasien menunjukkan tingkat stres akademis yang menurun.'
            ]);
        });
    }

    /**
     * TC_Counseling_002: Konselor mencoba menyimpan catatan evaluasi kosong.
     */
    public function test_konselor_mencoba_menyimpan_catatan_evaluasi_kosong()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create();
            $user = User::factory()->create();
            
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'jadwal' => now()->subHours(1)->format('Y-m-d H:i:s'),
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);

            $browser->loginAs($konselor->user)
                    ->visit('/konselor/jadwal')
                    ->pause(1000)
                    ->press('Beri Catatan')
                    ->pause(500);

            // Hilangkan atribut required via javascript agar bisa men-submit data kosong ke server
            $browser->script("document.getElementById('catatan_konselor').removeAttribute('required');");

            // Kosongkan dan kirim form
            $browser->type('catatan_konselor', '')
                    ->press('Simpan & Selesaikan Sesi')
                    ->pause(1000)
                    ->screenshot('pbi36-validasi-kosong');

            // Sesi tidak boleh terupdate menjadi completed
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'status' => 'confirmed',
                'catatan_konselor' => null
            ]);
        });
    }

    /**
     * TC_Counseling_003: User melihat catatan evaluasi pasca-sesi dari konselor.
     */
    public function test_user_melihat_catatan_evaluasi_pasca_sesi_dari_konselor()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create();
            $user = User::factory()->create();
            
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'jadwal' => now()->subDays(1)->format('Y-m-d H:i:s'),
                'status' => 'completed',
                'payment_status' => 'paid',
                'catatan_konselor' => 'Saran konselor: Terus lakukan teknik pernapasan 4-7-8 setiap malam.'
            ]);

            $browser->loginAs($user)
                    ->visit('/konseling/history')
                    ->pause(1500)
                    ->assertSee('Riwayat Sesi Konseling');

            $browser->assertSee('LIHAT CATATAN')
                    ->screenshot('pbi36-user-history');

            // Klik button Lihat Catatan
            $browser->press('LIHAT CATATAN')
                    ->pause(500)
                    ->assertPresent("#modal-history-note-{$sesi->sesi_konseling_id}")
                    ->assertSee('Saran konselor: Terus lakukan teknik pernapasan 4-7-8 setiap malam.')
                    ->screenshot('pbi36-user-viewing-note');
        });
    }
}
