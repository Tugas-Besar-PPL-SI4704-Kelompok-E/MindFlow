<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // Pastikan user test selalu ada di database dusk
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'nama_asli'    => 'Test User',
                'nama_samaran' => 'TestUser123',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'status'       => 'approved',
            ]
        );
    }

    /**
     * TC.Log.001: Menguji fungsionalitas login dengan kredensial valid (Positive)
     */
    public function test_tc_log_001_successful_login(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#email', 5)
                    ->type('#email', 'test@example.com')
                    ->type('#password', 'password')
                    ->press('#loginBtn')
                    ->pause(1000)
                    ->assertPathIs('/home');
        });
    }

    /**
     * TC.Log.002: Menguji validasi form wajib isi (Negative - HTML5)
     */
    public function test_tc_log_002_mandatory_fields_validation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#loginBtn', 5)
                    ->press('#loginBtn');
            $errorMessage = $browser->script("return document.querySelector('input[name=email]').validationMessage;")[0];
            $this->assertNotEmpty($errorMessage);
        });
    }

    /**
     * TC.Log.003: Menguji login dengan format email tidak valid (Negative - HTML5)
     */
    public function test_tc_log_003_invalid_email_format(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#email', 5)
                    ->type('#email', 'formatemailsalah')
                    ->type('#password', 'password123')
                    ->press('#loginBtn')
                    ->pause(2000);

            $errorMessage = $browser->script("return document.querySelector('input[name=email]').validationMessage;")[0];
            $this->assertStringContainsString('@', $errorMessage);
        });
    }

    /**
     * TC.Log.004: Menguji login dengan email yang belum terdaftar (Negative - Backend)
     */
    public function test_tc_log_004_unregistered_email(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#email', 5)
                    ->type('#email', 'woiwowioiw@test.com')
                    ->type('#password', '12345678')
                    ->press('#loginBtn')
                    ->pause(2000)
                    ->assertPathIs('/login')
                    ->assertSee('Email atau password yang Anda masukkan salah.');
        });
    }

    /**
     * TC.Log.005: Menguji login dengan password yang salah (Negative - Backend)
     */
    public function test_tc_log_005_wrong_password(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->waitFor('#email', 5)
                    ->type('#email', 'test@example.com')
                    ->type('#password', 'passwordsalah')
                    ->press('#loginBtn')
                    ->pause(2000)
                    ->assertPathIs('/login')
                    ->assertSee('Email atau password yang Anda masukkan salah.');
        });
    }
}
