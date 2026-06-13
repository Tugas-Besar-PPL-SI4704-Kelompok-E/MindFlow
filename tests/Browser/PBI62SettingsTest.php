<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\Spesialisasi;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * PBI #62 – Setting untuk Admin dan Konselor
 *
 * Skenario:
 *  A. Admin dapat mengakses menu pengaturan akun dan memperbarui nama serta password.
 *  B. Konselor dapat mengakses menu pengaturan profil dan memperbarui informasi profesional.
 */
class PBI62SettingsTest extends DuskTestCase
{
    use DatabaseMigrations;

    // ─────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────

    /** Login sebagai user tertentu lalu ambil screenshot konfirmasi. */
    private function loginAs(Browser $browser, User $user, string $password): void
    {
        $browser->visit('/login')
                ->waitFor('#email', 5)
                ->type('#email', $user->email)
                ->type('#password', $password)
                ->press('#loginBtn')
                ->pause(2000);
    }

    /** Logout melalui halaman /home (ada tombol profil & logout). */
    private function logout(Browser $browser): void
    {
        $browser->visit('/home')
                ->waitFor('#profileBtn', 5)
                ->click('#profileBtn')
                ->waitFor('#btn-logout', 5)
                ->click('#btn-logout')
                ->pause(1500);
    }

    // ─────────────────────────────────────────────────────────────────
    // Skenario A: Admin Settings
    // ─────────────────────────────────────────────────────────────────

    /**
     * @test
     * PBI-62-A: Admin dapat membuka halaman pengaturan.
     */
    public function test_admin_dapat_membuka_halaman_settings(): void
    {
        $admin = User::factory()->create([
            'email'       => 'admin62a@example.com',
            'password'    => Hash::make('password123'),
            'role'        => 'admin',
            'nama_asli'   => 'Admin Testing',
            'nama_samaran' => 'admin_testing_62a',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $this->loginAs($browser, $admin, 'password123');

            $browser->visit('/admin/settings')
                    ->assertSee('Pengaturan Akun')
                    ->assertSee('Profil Admin')
                    ->assertSee('Keamanan Akun')
                    ->screenshot('PBI-62-A1-Admin-Settings-Halaman');
        });
    }

    /**
     * @test
     * PBI-62-A: Admin dapat mengubah nama asli & nama samaran.
     */
    public function test_admin_dapat_update_nama(): void
    {
        $admin = User::factory()->create([
            'email'        => 'admin62b@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'admin',
            'nama_asli'    => 'Admin Lama',
            'nama_samaran' => 'admin_lama_62b',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $this->loginAs($browser, $admin, 'password123');

            $browser->visit('/admin/settings')
                    ->waitFor('input[name="nama_asli"]', 5)
                    ->screenshot('PBI-62-A2-Admin-Sebelum-Update');

            // Bersihkan field lalu isi nilai baru
            $browser->clear('input[name="nama_asli"]')
                    ->type('input[name="nama_asli"]', 'Admin Baru')
                    ->clear('input[name="nama_samaran"]')
                    ->type('input[name="nama_samaran"]', 'admin_baru_62b')
                    ->screenshot('PBI-62-A2-Admin-Form-Terisi')
                    ->press('Simpan Perubahan')
                    ->pause(2000);

            // Setelah submit harus muncul notifikasi sukses
            $browser->assertSee('berhasil')
                    ->screenshot('PBI-62-A2-Admin-Setelah-Update');
        });
    }

    /**
     * @test
     * PBI-62-A: Admin dapat mengubah password.
     */
    public function test_admin_dapat_update_password(): void
    {
        $admin = User::factory()->create([
            'email'        => 'admin62c@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'admin',
            'nama_asli'    => 'Admin Pass Test',
            'nama_samaran' => 'admin_pass_62c',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $this->loginAs($browser, $admin, 'password123');

            $browser->visit('/admin/settings')
                    ->waitFor('input[name="password"]', 5)
                    ->type('input[name="password"]', 'newpassword456')
                    ->type('input[name="password_confirmation"]', 'newpassword456')
                    ->screenshot('PBI-62-A3-Admin-Form-Password')
                    ->press('Simpan Perubahan')
                    ->pause(2000)
                    ->assertSee('berhasil')
                    ->screenshot('PBI-62-A3-Admin-Password-Updated');
        });
    }

    /**
     * @test
     * PBI-62-A: Admin mendapat error jika password konfirmasi tidak cocok.
     */
    public function test_admin_error_password_tidak_cocok(): void
    {
        $admin = User::factory()->create([
            'email'        => 'admin62d@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'admin',
            'nama_asli'    => 'Admin Error Test',
            'nama_samaran' => 'admin_err_62d',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $this->loginAs($browser, $admin, 'password123');

            $browser->visit('/admin/settings')
                    ->waitFor('input[name="password"]', 5)
                    ->type('input[name="password"]', 'newpassword456')
                    ->type('input[name="password_confirmation"]', 'salah_konfirmasi')
                    ->press('Simpan Perubahan')
                    ->pause(2000)
                    ->assertSee('confirmation')  // pesan error Laravel mengandung kata 'confirmation'
                    ->screenshot('PBI-62-A4-Admin-Error-Password');
        });
    }

    // ─────────────────────────────────────────────────────────────────
    // Skenario B: Konselor Settings
    // ─────────────────────────────────────────────────────────────────

    /**
     * @test
     * PBI-62-B: Konselor dapat membuka halaman pengaturan profil.
     */
    public function test_konselor_dapat_membuka_halaman_settings(): void
    {
        // Buat spesialisasi aktif agar select dropdown tidak kosong
        $sp = Spesialisasi::create(['nama' => 'Psikologi Klinis', 'is_active' => true]);

        $konselor = User::factory()->create([
            'email'        => 'konselor62a@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'konselor',
            'status'       => 'approved',
            'nama_asli'    => 'Konselor Testing',
            'nama_samaran' => 'konselor_testing_62a',
        ]);

        // Buat profil konselor agar halaman settings tidak crash
        ProfilKonselor::create([
            'user_id'        => $konselor->id,
            'nama'           => 'Konselor Testing',
            'spesialisasi'   => 'Psikologi Klinis',
            'nomor_whatsapp' => '081234567890',
            'no_sipp'        => 'SIPP-001',
            'biografi'       => 'Konselor berpengalaman.',
            'keahlian'       => 'Terapi Kognitif',
        ]);

        $this->browse(function (Browser $browser) use ($konselor) {
            $this->loginAs($browser, $konselor, 'password123');

            $browser->visit('/konselor/settings')
                    ->assertSee('Keamanan')
                    ->assertSee('Profil Profesional')
                    ->screenshot('PBI-62-B1-Konselor-Settings-Halaman');
        });
    }

    /**
     * @test
     * PBI-62-B: Konselor dapat mengubah informasi profil profesional.
     */
    public function test_konselor_dapat_update_profil_profesional(): void
    {
        $sp = Spesialisasi::create(['nama' => 'Terapi Keluarga', 'is_active' => true]);

        $konselor = User::factory()->create([
            'email'        => 'konselor62b@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'konselor',
            'status'       => 'approved',
            'nama_asli'    => 'Konselor Lama',
            'nama_samaran' => 'konselor_lama_62b',
        ]);

        ProfilKonselor::create([
            'user_id'        => $konselor->id,
            'nama'           => 'Konselor Lama',
            'spesialisasi'   => 'Terapi Keluarga',
            'nomor_whatsapp' => '081111111111',
            'no_sipp'        => 'SIPP-OLD',
            'biografi'       => 'Biografi lama.',
            'keahlian'       => 'Keahlian lama',
        ]);

        $this->browse(function (Browser $browser) use ($konselor) {
            $this->loginAs($browser, $konselor, 'password123');

            $browser->visit('/konselor/settings')
                    ->waitFor('input[name="nama_asli"]', 5)
                    ->screenshot('PBI-62-B2-Konselor-Sebelum-Update')
                    // Update nama
                    ->clear('input[name="nama_asli"]')
                    ->type('input[name="nama_asli"]', 'Konselor Baru')
                    ->clear('input[name="nama_samaran"]')
                    ->type('input[name="nama_samaran"]', 'konselor_baru_62b')
                    // Update biografi
                    ->clear('textarea[name="biografi"]')
                    ->type('textarea[name="biografi"]', 'Biografi yang sudah diperbarui.')
                    ->screenshot('PBI-62-B2-Konselor-Form-Terisi')
                    ->press('Simpan Profil')
                    ->pause(2000)
                    ->assertSee('berhasil')
                    ->screenshot('PBI-62-B2-Konselor-Setelah-Update');
        });
    }

    /**
     * @test
     * PBI-62-B: User biasa tidak bisa mengakses halaman settings konselor (redirect/403).
     */
    public function test_user_biasa_tidak_bisa_akses_settings_konselor(): void
    {
        $user = User::factory()->create([
            'email'        => 'user62@example.com',
            'password'     => Hash::make('password123'),
            'role'         => 'user',
            'nama_asli'    => 'User Biasa',
            'nama_samaran' => 'user_biasa_62',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $this->loginAs($browser, $user, 'password123');

            // Akses langsung, harus di-redirect atau dapat 403
            $browser->visit('/konselor/settings')
                    ->pause(1500);

            // Memastikan tidak berada di halaman settings konselor
            $browser->assertDontSee('Profil Profesional')
                    ->screenshot('PBI-62-B3-User-Ditolak-Settings-Konselor');
        });
    }
}
