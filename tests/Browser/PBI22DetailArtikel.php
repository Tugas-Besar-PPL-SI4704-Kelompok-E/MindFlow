<?php

namespace Tests\Browser;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI22DetailArtikel extends DuskTestCase
{
    /**
     * TC.DetailArt.001
     * Menguji fungsionalitas detail artikel (Positive)
     */
    public function test_menguji_fungsionalitas_detail_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $artikel = Artikel::published()->first();

            $browser->loginAs($user)
                    ->visit('/home') // Pre-condition: user berada di HomePage
                    ->visit('/artikel') // User menekan tombol "artikel" di navbar
                    ->waitFor('#artikel-card-' . $artikel->artikel_id) // Menunggu artikel tersedia
                    ->click('#artikel-card-' . $artikel->artikel_id) // Klik salah satu artikel
                    ->waitFor('#artikelModal.show') // Pop up muncul
                    ->assertVisible('#artikelModal.show'); // Memastikan pop up detail artikel muncul
        });
    }

    /**
     * TC.DetailArt.002
     * Menguji fungsionalitas isi artikel (Positive)
     */
    public function test_menguji_fungsionalitas_isi_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $artikel = Artikel::published()->first();

            $browser->loginAs($user)
                    ->visit('/home') // Pre-condition: user berada di HomePage
                    ->visit('/artikel') // User menekan tombol "artikel" di navbar
                    ->waitFor('#artikel-card-' . $artikel->artikel_id)
                    ->click('#artikel-card-' . $artikel->artikel_id) // Klik salah satu artikel
                    ->waitFor('#artikelModal.show') // Pop up muncul
                    ->click('#artikelModalReadBtn') // Klik tombol "Baca Selengkapnya"
                    ->assertPathIs('/artikel/' . $artikel->artikel_id); // User berpindah ke halaman isi artikel yang dipilih
        });
    }

    /**
     * TC.DetailArt.003
     * Menguji auth pada fitur artikel (Negative)
     */
    public function test_menguji_auth_pada_fitur_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $artikel = Artikel::published()->first();

            $browser->logout() // Memastikan guest
                    ->visit('/artikel/' . $artikel->artikel_id) // Pre-condition & Steps: Guest mengunjungi detail artikel langsung
                    ->assertPathIs('/login'); // Expected: Sistem akan menolak karena belum login
        });
    }
}
