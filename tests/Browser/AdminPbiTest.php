<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class AdminPbiTest extends DuskTestCase
{
    /**
     * Test semua PBI Admin secara berurutan dan ambil screenshot secara otomatis.
     */
    public function test_admin_pbis(): void
    {
        // Kita buatkan akun admin sementara agar test bisa jalan sendiri
        $adminEmail = 'admin_dusk_' . time() . '@example.com';
        $admin = User::create([
            'nama_asli' => 'Admin Dusk',
            'nama_samaran' => 'AdminDusk',
            'email' => $adminEmail,
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            
            // 1. Proses Login
            $browser->visit('/login')
                    ->waitFor('#email')
                    ->type('#email', $admin->email)
                    ->type('#password', 'password123')
                    ->press('Masuk')
                    ->pause(2000); // Tunggu login selesai

            // 2. PBI 42: Bar metrik total pengguna, dll.
            $browser->visit('/admin/dashboard')
                    ->pause(1500)
                    ->screenshot('PBI-42-Dashboard-Metrik');

            // 3. PBI 37: Page rekrutmen aplikan calon konselor
            $browser->visit('/admin/rekrutmen')
                    ->pause(1500)
                    ->screenshot('PBI-37-Rekrutmen-Konselor');

            // 4. PBI 38: Page list laporan pelanggaran konten.
            $browser->visit('/admin/laporan')
                    ->pause(1500)
                    ->screenshot('PBI-38-Laporan-Pelanggaran');

            // 5. PBI 39: Pengelolaan kategori spesialisasi konselor.
            $browser->visit('/admin/spesialisasi')
                    ->pause(1500)
                    ->screenshot('PBI-39-Pengelolaan-Spesialisasi');
            
            // 6. PBI 40: Fitur eksekusi penghapusan postingan forum secara permanen.
            // Fitur ini biasanya berada di halaman laporan, jadi kita akan meng-SS halaman laporan lagi
            // sebagai bukti bahwa halamannya bisa diakses (atau kamu bisa sesuaikan linknya nanti).
            $browser->visit('/admin/laporan')
                    ->pause(1500)
                    ->screenshot('PBI-40-Halaman-Laporan-Dan-Hapus');

            // Terakhir logout
            $browser->visit('/home') // ke halaman yang ada tombol profil
                    ->click('#profileBtn')
                    ->waitFor('#btn-logout', 5)
                    ->click('#btn-logout')
                    ->pause(1000);
        });

        // Bersihkan admin sementara setelah test selesai
        $admin->delete();
    }
}
