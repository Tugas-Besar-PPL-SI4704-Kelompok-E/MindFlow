<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class FaqAndLogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * [Positive] TC-14.1: Akses FAQ (Guest) - halaman tampil
     */
    public function test_TC_14_1_guest_can_access_faq_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/faq')
                    ->assertPathIs('/faq');
        });
    }

    /**
     * [Negative] TC-14.2: Guest yang akses /home harus diarahkan ke /login
     */
    public function test_TC_14_2_guest_cannot_access_protected_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/home')
                    ->assertPathIs('/login');
        });
    }

    /**
     * [Positive] TC-14.3: Melakukan Logout via form login manual
     */
    public function test_TC_14_3_user_can_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'logout_test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()
                    ->visit('/login')
                    ->waitFor('#email')
                    ->type('#email', $user->email)
                    ->type('#password', 'password123')
                    ->press('Masuk')
                    ->pause(1000)
                    ->assertPathIs('/home')
                    ->click('#profileBtn')
                    ->waitFor('#btn-logout', 5)
                    ->click('#btn-logout')
                    ->pause(1000)
                    ->assertGuest();
        });
    }

    /**
     * [Negative] TC-14.4: Akses Dashboard Pasca Logout - harus diarahkan ke /login
     */
    public function test_TC_14_4_user_cannot_go_back_to_home_after_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'logout_test2@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()
                    ->visit('/login')
                    ->type('#email', $user->email)
                    ->type('#password', 'password123')
                    ->press('Masuk')
                    ->pause(1000)
                    ->assertPathIs('/home')
                    ->click('#profileBtn')
                    ->waitFor('#btn-logout', 5)
                    ->click('#btn-logout')
                    ->pause(1000)
                    ->visit('/home')
                    ->assertPathIs('/login');
        });
    }
}
