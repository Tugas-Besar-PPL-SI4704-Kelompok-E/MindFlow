<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class HomepageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * [Positive] TC-4.1: Login Sukses
     */
    public function test_TC_4_1_user_can_access_homepage_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->waitFor('#email')
                    ->type('#email', $user->email)
                    ->type('#password', 'password123')
                    ->press('Masuk')
                    ->pause(1000) // Beri waktu redirect
                    ->assertPathIs('/home');
        });
    }

    /**
     * [Negative] TC-4.2: Login Gagal (Password Salah)
     */
    public function test_TC_4_2_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'email' => 'benar@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->waitFor('#email')
                    ->type('#email', $user->email)
                    ->type('#password', 'salah123')
                    ->press('Masuk')
                    ->pause(500)
                    ->assertPathIs('/login');
        });
    }

    /**
     * [Positive] TC-4.3: Pendaftaran Akun (Sign Up)
     */
    public function test_TC_4_3_user_can_register(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->waitFor('#nama_asli')
                    ->type('#nama_asli', 'Test User')
                    ->type('#nama_samaran', 'TestAlias')
                    ->type('#email', 'newuser' . rand(0,999) . '@example.com')
                    ->type('#password', 'password123')
                    ->type('#password_confirmation', 'password123')
                    ->press('Buat Akun')
                    ->pause(1500) // Pendaftaran butuh waktu lebih lama
                    ->assertPathIs('/home');
        });
    }

    /**
     * [Negative] TC-4.4: Akses Homepage Tanpa Auth
     */
    public function test_TC_4_4_guest_cannot_access_homepage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                    ->assertPathIs('/login');
        });
    }
}
