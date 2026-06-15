<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI23SearchFilterArtikel extends DuskTestCase
{
    /**
     * TC.Search.001
     * Menguji fungsionalitas search artikel (Positive)
     */
    public function test_menguji_fungsionalitas_search_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $browser->loginAs($user)
                    ->visit('/artikel') // Pre-condition: User berada di halaman artikel
                    ->click('#artikel-search') // Klik input pencarian
                    ->type('#artikel-search', '5 Teknik') // Ketik keyword
                    ->keys('#artikel-search', '{enter}') // Tekan enter untuk men-submit form
                    ->pause(1000) // Tunggu proses selesai
                    ->assertSee('5 Teknik Mindfulness untuk Mengurangi Stres'); // Validasi artikel muncul
        });
    }

    /**
     * TC.Search.002
     * Menguji fungsionalitas search artikel #2 (Negative)
     */
    public function test_menguji_fungsionalitas_search_artikel_negative(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $browser->loginAs($user)
                    ->visit('/artikel') // Pre-condition: User berada di halaman artikel
                    ->click('#artikel-search') // Klik input pencarian
                    ->type('#artikel-search', '6 Teknik') // Ketik keyword yang tidak ada
                    ->keys('#artikel-search', '{enter}') // Tekan enter
                    ->pause(1000)
                    ->assertSee('Artikel Tidak Ditemukan'); // Validasi empty state muncul
        });
    }

    /**
     * TC.Search.003
     * Menguji fungsionalitas filter artikel (Positive)
     */
    public function test_menguji_fungsionalitas_filter_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $browser->loginAs($user)
                    ->visit('/artikel') // Pre-condition: User berada di halaman artikel
                    ->click('#artikel-filter') // Klik dropdown semua kategori
                    ->select('#artikel-filter', 'Edukasi') // Pilih kategori Edukasi (dropdown ada onchange submit)
                    ->pause(1000)
                    ->assertSee('Edukasi'); // Validasi artikel berkategori edukasi muncul (teks badge filter/artikel "Edukasi")
        });
    }
}
