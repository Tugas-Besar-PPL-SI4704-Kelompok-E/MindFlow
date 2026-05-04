<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class SettingsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Helper untuk login manual agar sesi benar-benar terbentuk di browser
     */
    protected function loginUser(Browser $browser, User $user, string $password = 'password123')
    {
        return $browser->visit('/login')
                       ->waitFor('#email')
                       ->type('#email', $user->email)
                       ->type('#password', $password)
                       ->press('Masuk')
                       ->pause(1000)
                       ->assertPathIs('/home');
    }

    /**
     * [Positive] TC-13.1: Update Profil Berhasil
     */
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

    /**
     * [Negative] TC-13.2: Update Gagal (Nama Samaran Duplikat)
     */
    public function test_TC_13_2_user_cannot_update_with_duplicate_nama_samaran(): void
    {
        $password = 'password123';
        $userA = User::factory()->create(['nama_samaran' => 'aliasA']);
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

    /**
     * [Positive] TC-13.3: Ubah Password Berhasil
     */
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

    /**
     * [Negative] TC-13.4: Ubah Password Gagal (Konfirmasi Salah)
     */
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
}
