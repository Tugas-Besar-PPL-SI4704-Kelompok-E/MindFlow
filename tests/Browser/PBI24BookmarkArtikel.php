<?php

namespace Tests\Browser;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI24BookmarkArtikel extends DuskTestCase
{
    /**
     * TC.Bookmark.001
     * Menguji fungsionalitas bookmark artikel (Positive)
     */
    public function test_menguji_fungsionalitas_bookmark_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $artikelId = 1; // Menggunakan artikel id = 1 sesuai instruksi
            $artikel = Artikel::find($artikelId);

            // Bersihkan bookmark sebelumnya untuk memastikan status awal tidak terbookmark
            $artikel->bookmarks()->where('user_id', $user->id)->delete();

            $browser->loginAs($user)
                    ->visit('/artikel') // Pre-condition: User berada di halaman artikel
                    ->waitFor('#artikel-card-' . $artikelId) // Pastikan artikel sudah termuat
                    ->click('#artikel-card-' . $artikelId . ' button') // Klik button Bookmark pada salah satu artikel
                    ->pause(1500) // Tunggu request AJAX selesai
                    // Validasi class berubah (misal button menjadi text-[#A881C2])
                    ->assertPresent('#artikel-card-' . $artikelId . ' button.text-\\[\\#A881C2\\]')
                    ->clickLink('Bookmark Saya') // Klik button "Bookmark saya"
                    ->pause(1000)
                    ->assertPathIs('/artikel/bookmarks') // User diarahkan ke halaman bookmarks
                    ->assertSee($artikel->judul); // Artikel yang ter-Bookmark akan muncul
        });
    }

    /**
     * TC.Bookmark.002
     * Menguji auth pada fitur bookmark (Negative)
     */
    public function test_menguji_auth_pada_fitur_bookmark(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout() // Pastikan sebagai guest
                    ->visit('/artikel/bookmarks') // Guest mengunjungi halaman bookmark
                    ->assertPathIs('/login'); // Sistem menolak karena belum login
        });
    }
}
