<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI27FilterKonselorTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * PBI 27: Filter pencarian konselor berdasarkan kategori spesialisasi
     */
    public function test_menampilkan_konselor_berdasarkan_spesialisasi_yang_dipilih()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);
            $konselor3 = ProfilKonselor::factory()->create(['spesialisasi' => 'Karir']);

            $browser->loginAs($user)
                    ->visit('/konseling')
                    ->pause(3000)
                    ->assertSee($konselor1->nama)
                    ->assertSee($konselor2->nama)
                    ->assertSee($konselor3->nama)
                    ->select('spesialisasi', 'Kesehatan Mental')
                    ->pause(2000)
                    ->assertSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama)
                    ->assertDontSee($konselor3->nama);
        });
    }

    /**
     * PBI 27 (Negative Test): User memfilter konselor dengan kategori spesialisasi yang tidak ada dalam sistem
     * 
     * Pre-condition:
     * - User sudah login
     * - User berada pada halaman daftar konselor
     * - Sistem sudah memiliki data konselor dengan beberapa spesialisasi
     * 
     * Steps:
     * 1. Sistem menampilkan halaman daftar konselor dengan list lengkap konselor
     * 2. User memilih kategori spesialisasi yang tidak memiliki konselor (spesialisasi tidak ada dalam sistem)
     * 3. Sistem memproses hasil filter
     * 4. User dapat membatalkan filter atau kembali ke daftar konselor lengkap
     */
    public function test_menampilkan_pesan_konselor_tidak_ditemukan_ketika_filter_tidak_ada_hasil()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            // Setup: Buat konselor dengan spesialisasi tertentu
            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);
            $konselor3 = ProfilKonselor::factory()->create(['spesialisasi' => 'Karir']);

            $browser->loginAs($user)
                    // Step 1: Verifikasi halaman daftar konselor menampilkan list lengkap
                    ->visit('/konseling')
                    ->pause(3000)
                    ->assertSee($konselor1->nama)
                    ->assertSee($konselor2->nama)
                    ->assertSee($konselor3->nama)
                    
                    // Step 2 & 3: User memfilter dengan spesialisasi yang TIDAK ada dalam sistem
                    // Akses filter dengan langsung menggunakan URL (simulate selecting non-existent specialization)
                    ->visit('/konseling?spesialisasi=Terapi Keluarga')
                    ->pause(2000)
                    
                    // Verifikasi: Menampilkan pesan "Konselor Tidak Ditemukan"
                    ->assertSee('Konselor Tidak Ditemukan')
                    ->assertSee('Maaf, saat ini belum ada konselor yang tersedia untuk kategori tersebut.')
                    
                    // Verifikasi: Tidak ada konselor yang ditampilkan
                    ->assertDontSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama)
                    ->assertDontSee($konselor3->nama);
        });
    }

    /**
     * PBI 27 (Negative Test): User dapat membatalkan filter dan kembali ke daftar konselor lengkap
     * 
     * Expected Result:
     * - User dapat klik tombol "Lihat Semua Konselor" atau reset filter
     * - Halaman kembali menampilkan list lengkap konselor
     */
    public function test_user_dapat_membatalkan_filter_dan_kembali_ke_daftar_lengkap()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);

            $browser->loginAs($user)
                    // Setup: User memfilter dengan spesialisasi yang tidak ada
                    ->visit('/konseling?spesialisasi=Terapi Keluarga')
                    ->pause(2000)
                    ->assertSee('Konselor Tidak Ditemukan')
                    
                    // User klik tombol "Lihat Semua Konselor" untuk reset filter
                    ->click('a[href="' . route('konseling.index') . '"]')
                    ->pause(3000)
                    ->assertPathIs('/konseling')
                    
                    // Verifikasi: Halaman kembali menampilkan list lengkap konselor
                    ->assertSee($konselor1->nama)
                    ->assertSee($konselor2->nama);
        });
    }

    /**
     * PBI 27 (Negative Test): User dapat menggunakan tombol reset filter (X button) 
     * untuk kembali ke daftar konselor lengkap
     */
    public function test_user_dapat_reset_filter_menggunakan_tombol_x()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);

            $browser->loginAs($user)
                    // User memfilter dengan spesialisasi yang tidak ada
                    ->visit('/konseling?spesialisasi=Terapi Keluarga')
                    ->pause(2000)
                    ->assertSee('Konselor Tidak Ditemukan')
                    
                    // User klik tombol X untuk reset filter
                    ->click('a[title="Reset Filter"]')
                    ->pause(3000)
                    ->assertPathIs('/konseling')
                    
                    // Verifikasi: Halaman kembali menampilkan list lengkap konselor
                    ->assertSee($konselor1->nama)
                    ->assertSee($konselor2->nama);
        });
    }
}
