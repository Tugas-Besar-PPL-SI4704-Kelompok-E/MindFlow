<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_tc_reg_001_successful_registration(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register') 
                    ->type('nama_asli', 'Pengguna Uji Coba')
                    ->type('nama_samaran', 'UserTest123')
                    ->type('email', 'testuser6@mindflow.com')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->press('Buat Akun')
                    ->pause(1000)
                    ->assertSee('Homepage');
        });
    }

    /**
     * TC.Reg.002: Menguji validasi form wajib isi (Negative)
     */
    public function test_tc_reg_002_mandatory_fields_validation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->press('Buat Akun');
            $errorMessage = $browser->script("return document.querySelector('input[name=nama_asli]').validationMessage;")[0];
            $this->assertEquals('Please fill out this field.', $errorMessage);
        });
    }

    /**
     * TC.Reg.003: Menguji validasi format email (Negative)
     */
    public function test_tc_reg_003_email_format_validation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('nama_asli', 'Pengguna Uji Coba')
                    ->type('nama_samaran', 'UserTest')
                    ->type('email', 'testuser.com')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')
                    ->press('Buat Akun')
                    ->assertPathIs('/register');
            $errorMessage = $browser->script("return document.querySelector('input[name=email]').validationMessage;")[0];
            $this->assertStringContainsString("Please include an '@'", $errorMessage);; 
        });
    }

    /**
     * TC.Reg.004: Menguji validasi panjang minimum password (Negative)
     */
    public function test_tc_reg_004_password_minimum_length_validation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('nama_asli', 'Pengguna Uji Coba')
                    ->type('nama_samaran', 'UserTest')
                    ->type('email', 'testuser2@mindflow.com')
                    ->type('password', '12345') 
                    ->type('password_confirmation', '12345')
                    ->press('Buat Akun')
                    ->assertPathIs('/register');
            $errorMessage = $browser->script("return document.querySelector('input[name=password]').validationMessage; ")[0];
            $this->assertStringContainsString("Please lengthen this text to 8 characters or more (you are currently using 5 characters).", $errorMessage); 
        });
    }

    /**
     * TC.Reg.005: Menguji kecocokan konfirmasi password (Negative)
     */
    public function test_tc_reg_005_password_confirmation_mismatch_validation(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('nama_asli', 'Pengguna Uji Coba')
                    ->type('nama_samaran', 'UserTest')
                    ->type('email', 'testuser12341241@mindflow.com')
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password321')
                    ->press('Buat Akun')
                    ->assertPathIs('/register');
        });
    }
}