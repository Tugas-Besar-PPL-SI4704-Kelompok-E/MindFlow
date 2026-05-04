<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI31PerubahanJadwalTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 31: Alur pengajuan perubahan jadwal sesi
     */
    public function test_memperbarui_jadwal_sesi_konseling_di_database()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'jadwal' => '2026-05-10 10:00:00',
                'status' => 'pending'
            ]);

            $browser->visit("/booking/{$sesi->sesi_konseling_id}/edit")
                    ->type('jadwal', '2026-05-11T14:00')
                    ->press('Simpan Perubahan');
            
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'jadwal' => '2026-05-11 14:00:00',
                'status' => 'rescheduled'
            ]);
        });
    }

    /**
     * PBI 31 (Tambahan): Membatalkan sesi konseling
     */
    public function test_membatalkan_sesi_konseling_dengan_status_cancelled()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'status' => 'pending'
            ]);

            $browser->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->press('Batalkan')
                    ->acceptDialog();
            
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'status' => 'cancelled'
            ]);
        });
    }
}
