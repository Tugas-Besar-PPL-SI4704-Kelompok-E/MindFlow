<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class MindFlowTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Helper untuk login — menggunakan loginAs agar session langsung terbentuk
     * tanpa bergantung pada form browser (menghindari stale session issue).
     */
    protected function loginUser(Browser $browser, User $user, string $password = 'password123')
    {
        return $browser->loginAs($user)
                       ->visit('/home')
                       ->assertPathIs('/home');
    }

    // =========================================================================
    // PBI 4: AUTENTIKASI & REGISTRASI
    // =========================================================================

    /** [Positive] TC-4.1: Login Sukses */
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
                    ->pause(1000)
                    ->assertPathIs('/home');
        });
    }

    /** [Negative] TC-4.2: Login Gagal (Password Salah) */
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

    /** [Positive] TC-4.3: Pendaftaran Akun (Sign Up) */
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
                    ->pause(1500)
                    ->assertPathIs('/home');
        });
    }

    /** [Negative] TC-4.4: Akses Homepage Tanpa Auth */
    public function test_TC_4_4_guest_cannot_access_homepage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                    ->assertPathIs('/login');
        });
    }

    // =========================================================================
    // PBI 13: PENGATURAN PROFIL & KEAMANAN
    // =========================================================================

    /** [Positive] TC-13.1: Update Profil Berhasil */
    public function test_TC_13_1_user_can_update_profile_settings(): void
    {
        $password = 'password123';
        $user = User::factory()->create([
            'nama_asli' => 'Nama Lama',
            'nama_samaran' => 'Alias Lama',
            'password' => Hash::make($password),
        ]);

        $this->browse(function (Browser $browser) use ($user, $password) {
            $this->loginUser($browser, $user, $password)
                    ->visit('/settings')
                    ->waitFor('#nama_asli')
                    ->type('#nama_asli', 'Nama Baru')
                    ->type('#nama_samaran', 'Alias Baru')
                    ->press('Simpan Perubahan')
                    ->pause(1000)
                    ->assertPathIs('/settings')
                    ->assertSee('berhasil');
        });
    }

    /** [Negative] TC-13.2: Update Gagal (Nama Samaran Duplikat) */
    public function test_TC_13_2_user_cannot_update_with_duplicate_nama_samaran(): void
    {
        $password = 'password123';
        User::factory()->create(['nama_samaran' => 'aliasA']);
        $userB = User::factory()->create([
            'nama_samaran' => 'aliasB',
            'password' => Hash::make($password),
        ]);

        $this->browse(function (Browser $browser) use ($userB, $password) {
            $this->loginUser($browser, $userB, $password)
                    ->visit('/settings')
                    ->waitFor('#nama_samaran')
                    ->type('#nama_samaran', 'aliasA')
                    ->press('Simpan Perubahan')
                    ->pause(500)
                    ->assertPathIs('/settings');
        });
    }

    /** [Positive] TC-13.3: Ubah Password Berhasil */
    public function test_TC_13_3_user_can_change_password_successfully(): void
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $this->browse(function (Browser $browser) use ($user, $password) {
            $this->loginUser($browser, $user, $password)
                    ->visit('/settings')
                    ->waitFor('#password')
                    ->type('#password', 'passwordBaru123')
                    ->type('#password_confirmation', 'passwordBaru123')
                    ->press('Simpan Perubahan')
                    ->pause(1000)
                    ->assertPathIs('/settings')
                    ->assertSee('berhasil');
        });
    }

    /** [Negative] TC-13.4: Ubah Password Gagal (Konfirmasi Salah) */
    public function test_TC_13_4_user_cannot_update_password_with_mismatched_confirmation(): void
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $this->browse(function (Browser $browser) use ($user, $password) {
            $this->loginUser($browser, $user, $password)
                    ->visit('/settings')
                    ->waitFor('#password')
                    ->type('#password', 'passwordBaru123')
                    ->type('#password_confirmation', 'passwordBeda999')
                    ->press('Simpan Perubahan')
                    ->pause(500)
                    ->assertPathIs('/settings');
        });
    }

    // =========================================================================
    // PBI 14: FAQ & LOGOUT
    // =========================================================================

    /** [Positive] TC-14.1: Akses FAQ (Guest) */
    public function test_TC_14_1_guest_can_access_faq_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/faq')
                    ->assertPathIs('/faq');
        });
    }

    /** [Negative] TC-14.2: Guest yang akses /home diarahkan ke /login */
    public function test_TC_14_2_guest_cannot_access_protected_page(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit('/home')
                    ->assertPathIs('/login');
        });
    }

    /** [Positive] TC-14.3: Logout via form */
    public function test_TC_14_3_user_can_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'logout_test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
                    ->assertPathIs('/home')
                    ->click('#profileBtn')
                    ->waitFor('#btn-logout', 5)
                    ->click('#btn-logout')
                    ->pause(1000)
                    ->assertGuest();
        });
    }

    /** [Negative] TC-14.4: Akses Dashboard Pasca Logout */
    public function test_TC_14_4_user_cannot_go_back_to_home_after_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'logout_test2@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/home')
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
