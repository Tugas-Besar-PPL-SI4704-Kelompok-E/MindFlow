<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI33RiwayatSesiRentangWaktuTest extends DuskTestCase
{
    use DatabaseMigrations;

    


    public function test_riwayat_sesi_dapat_difilter_berdasarkan_rentang_waktu()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $konselorInRange = ProfilKonselor::factory()->create();
            $konselorOutOfRange = ProfilKonselor::factory()->create();

            SesiKonseling::factory()->create([
                'user_id' => $user->id,
                'profil_konselor_id' => $konselorInRange->profil_konselor_id,
                'status' => 'completed',
                'jadwal' => now()->subDays(20)->format('Y-m-d H:i:s'),
            ]);

            SesiKonseling::factory()->create([
                'user_id' => $user->id,
                'profil_konselor_id' => $konselorOutOfRange->profil_konselor_id,
                'status' => 'completed',
                'jadwal' => now()->subDays(120)->format('Y-m-d H:i:s'),
            ]);

            $browser->loginAs($user)
                    ->visit('/konseling/history?range=1_month')
                    ->pause(1000)
                    ->assertSee('Riwayat Sesi Konseling')
                    ->assertSee('1 Bulan Terakhir')
                    ->assertSee($konselorInRange->user->name)
                    ->assertDontSee($konselorOutOfRange->user->name)
                    ->assertSee('SELESAI');
        });
    }
}
