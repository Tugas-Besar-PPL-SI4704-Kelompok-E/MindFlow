<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI28ProfilDetailKonselorTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 28: Halaman profil detail konselor (biografi & keahlian)
     */
    public function test_menampilkan_profil_detail_konselor_dengan_biografi_dan_keahlian()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create([
                'biografi' => 'Konselor profesional dengan pengalaman 5 tahun',
                'keahlian' => 'Terapi Kognitif Perilaku, Konseling Keluarga'
            ]);

            $browser->visit("/konseling/{$konselor->profil_konselor_id}")
                    ->assertSee($konselor->nama)
                    ->assertSee($konselor->biografi)
                    ->assertSee($konselor->keahlian);
        });
    }
}
