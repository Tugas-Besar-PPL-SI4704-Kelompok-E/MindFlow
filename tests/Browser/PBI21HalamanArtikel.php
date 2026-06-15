<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI21HalamanArtikel extends DuskTestCase
{
    /**
     * TC.PageArtikel.001
     * Menguji fungsionalitas halaman artikel (Positive)
     * Menggunakan login otomatis sehingga tidak perlu melalui form login
     */
    public function test_menguji_fungsionalitas_halaman_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::first();

            $browser->loginAs($user)
                    ->visit('/home') // Pre-condition: user berada di HomePage
                    ->visit('/artikel') // User mengunjungi halaman artikel (bisa diwakili dengan mengklik atau visit langsung)
                    ->assertPathIs('/artikel'); // Expected: User akan berpindah ke halaman artikel
        });
    }

    /**
     * TC.PageArtikel.002
     * Menguji auth pada fitur artikel (Negative)
     */
    public function test_menguji_auth_pada_fitur_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout() // Memastikan guest
                    ->visit('/artikel') // Pre-condition & Steps: Guest mengetik path /artikel
                    ->assertPathIs('/login'); // Expected: Sistem akan menolak karena belum login
        });
    }
}
