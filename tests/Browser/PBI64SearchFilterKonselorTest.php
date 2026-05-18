<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI64SearchFilterKonselorTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 64: Search konselor berdasarkan nama, keahlian, atau gejala
     */
    public function test_pbi_64_dapat_mencari_konselor_berdasarkan_keyword_search()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create([
                'nama' => 'Riana Ar-Zahra, M.Psi.',
                'keahlian' => 'Terapi Kognitif',
                'gejala' => 'Depresi'
            ]);
            $konselor2 = ProfilKonselor::factory()->create([
                'nama' => 'Budi Rahardjo, S.Psi.',
                'keahlian' => 'Konseling Akademik',
                'gejala' => 'Stres'
            ]);

            $browser->loginAs($user)
                    ->visit('/konseling?search=Depresi')
                    ->pause(2500)
                    ->assertSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama);
        });
    }

    /**
     * PBI 64: Filter konselor hanya menampilkan yang tersedia
     */
    public function test_pbi_64_dapat_filter_konselor_tersedia()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Karir']);

            SesiKonseling::factory()->create(['profil_konselor_id' => $konselor1->profil_konselor_id, 'status' => 'pending']);
            SesiKonseling::factory()->create(['profil_konselor_id' => $konselor2->profil_konselor_id, 'status' => 'penuh']);

            $browser->loginAs($user)
                    ->visit('/konseling?ketersediaan=tersedia')
                    ->pause(2500)
                    ->assertSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama);
        });
    }

    /**
     * PBI 64: Integrasi search + filter spesialisasi + ketersediaan
     */
    public function test_pbi_64_integrasi_search_spesialisasi_dan_ketersediaan()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create([
                'nama' => 'Riana Ar-Zahra, M.Psi.',
                'spesialisasi' => 'Kesehatan Mental',
                'gejala' => 'Depresi'
            ]);
            $konselor2 = ProfilKonselor::factory()->create([
                'nama' => 'Budi Rahardjo, S.Psi.',
                'spesialisasi' => 'Kesehatan Mental',
                'gejala' => 'Stres'
            ]);
            $konselor3 = ProfilKonselor::factory()->create([
                'nama' => 'Siti Amina, M.Psi.',
                'spesialisasi' => 'Karir',
                'gejala' => 'Depresi'
            ]);

            SesiKonseling::factory()->create(['profil_konselor_id' => $konselor1->profil_konselor_id, 'status' => 'pending']);
            SesiKonseling::factory()->create(['profil_konselor_id' => $konselor2->profil_konselor_id, 'status' => 'penuh']);
            SesiKonseling::factory()->create(['profil_konselor_id' => $konselor3->profil_konselor_id, 'status' => 'pending']);

            $browser->loginAs($user)
                    ->visit('/konseling?search=Depresi&spesialisasi=Kesehatan%20Mental&ketersediaan=tersedia')
                    ->pause(2500)
                    ->assertSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama)
                    ->assertDontSee($konselor3->nama);
        });
    }
}
