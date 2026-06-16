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

    


    public function test_memperbarui_jadwal_sesi_konseling_di_database()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $initialJadwal = now()->addDays(5)->format('Y-m-d H:i:s');
            $newJadwal = now()->addDays(6)->format('Y-m-d\TH:i');

            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'jadwal' => $initialJadwal,
                'status' => 'pending'
            ]);

            $browser->loginAs($user)
                    ->visit("/booking/edit/{$sesi->sesi_konseling_id}")
                    ->waitFor('input[name="jadwal"]', 5);

            $browser->script([
                'document.querySelector("input[name=\"jadwal\"]").value = "' . $newJadwal . '";',
                'document.querySelector("input[name=\"jadwal\"]").dispatchEvent(new Event("change", { bubbles: true }));'
            ]);

            $browser->press('Kirim Pengajuan')
                    ->pause(1000); 
            
            $this->assertDatabaseHas('sesi_konselings', [
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'requested_jadwal' => $newJadwal,
                'status' => 'change_requested'
            ]);
        });
    }

    


    public function test_membatalkan_sesi_konseling_dengan_status_cancelled()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselor = ProfilKonselor::factory()->create();
            $initialJadwal = now()->addDays(5)->format('Y-m-d H:i:s');
            $sesi = SesiKonseling::factory()->create([
                'profil_konselor_id' => $konselor->profil_konselor_id,
                'user_id' => $user->id,
                'jadwal' => $initialJadwal,
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
