<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI27FilterKonselorTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 27: Filter pencarian konselor berdasarkan kategori spesialisasi
     */
    public function test_menampilkan_konselor_berdasarkan_spesialisasi_yang_dipilih()
    {
        $this->browse(function (Browser $browser) {
            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);
            $konselor3 = ProfilKonselor::factory()->create(['spesialisasi' => 'Karir']);

            $browser->visit('/konseling')
                    ->assertSee($konselor1->nama)
                    ->assertSee($konselor2->nama)
                    ->assertSee($konselor3->nama)
                    ->select('spesialisasi', 'Kesehatan Mental')
                    ->assertSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama)
                    ->assertDontSee($konselor3->nama);
        });
    }
}
