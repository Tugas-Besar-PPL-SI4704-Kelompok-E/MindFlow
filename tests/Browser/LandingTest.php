<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LandingTest extends DuskTestCase
{
    use DatabaseMigrations;

   /**
     * TC.Land.001: Menguji navigasi menu utama
     */
    public function test_tc_land_001_navbar_navigation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('.navbar', 5)
                    ->click('a[href="#features"]')
                    ->pause(500)
                    ->assertSee('Semua yang Anda Butuhkan');
        });
    }

    /**
     * TC.Land.002: Menguji akses halaman Login dari Landing Page
     */
    public function test_tc_land_002_access_login_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('.navbar', 5)
                    ->click('.btn-login')
                    ->assertPathIs('/login');
        });
    }

    /**
     * TC.Land.003: Menguji akses halaman Register dari Landing Page
     */
    public function test_tc_land_003_access_register_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('.navbar', 5)
                    ->click('.btn-signup')
                    ->assertPathIs('/register');
        });
    }

    /**
     * TC.Land.004: Menguji tombol fitur spesifik (Cek Kesehatan Mental Gratis)
     */
    public function test_tc_land_004_specific_feature_button(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->waitFor('.hero-actions', 5)
                    ->click('.btn-hero-accent')
                    ->assertPathIs('/mood-tracker/mendalam');
        });
    }
}
