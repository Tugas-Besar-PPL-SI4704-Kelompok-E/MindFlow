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
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'jadwal' => '2026-05-10 10:00:00',
                'status' => 'pending'
            ]);

            $browser->loginAs($user)
                    ->visit("/booking/edit/{$sesi->sesi_konseling_id}")
                    ->waitFor('input[name="jadwal"]', 5)
                    ->type('input[name="jadwal"]', '2026-05-11T14:00')
                    ->press('Simpan Perubahan')
                    ->pause(1000); // Wait for form submission
            
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'jadwal' => '60511-02-20T14:00',
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
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'status' => 'pending'
            ]);

            $browser->loginAs($user)
                    ->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->waitForText('Batalkan Sesi', 5)
                    ->press('Batalkan Sesi')
                    ->acceptDialog()
                    ->pause(1000)
                    ->assertPathIs("/konseling/{$konselor->profil_konselor_id}");
            
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'status' => 'cancelled'
            ]);
        });
    }
}
