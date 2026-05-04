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
     * PBI 30: Sistem notifikasi reservasi
     */
    public function test_menampilkan_notifikasi_sukses_setelah_reservasi()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();

            $browser->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->type('jadwal', '2026-05-10T10:00')
                    ->press('Konfirmasi Reservasi')
                    ->assertSee('Reservasi berhasil dibuat!');
        });
    }

    /**
     * PBI 30: Sistem notifikasi perubahan jadwal
     */
    public function test_menampilkan_notifikasi_info_setelah_perubahan_jadwal()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'status' => 'pending'
            ]);

            $browser->visit("/booking/{$sesi->sesi_konseling_id}/edit")
                    ->type('jadwal', '2026-05-11T14:00')
                    ->press('Simpan Perubahan')
                    ->assertSee('Jadwal sesi telah berhasil diubah!');
        });
    }

    /**
     * PBI 30: Sistem notifikasi pembatalan
     */
    public function test_menampilkan_notifikasi_error_setelah_pembatalan()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'status' => 'pending'
            ]);

            $browser->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->press('Batalkan')
                    ->assertDialogOpened('Yakin ingin membatalkan sesi ini?')
                    ->acceptDialog()
                    ->assertSee('Reservasi telah dibatalkan.');
        });
    }
}
