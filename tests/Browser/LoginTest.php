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
