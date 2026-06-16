<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PBI63NavbarRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();

        // Daftarkan route testing sementara untuk me-render layout utama (navbar/sidebar)
        // guna menghindari query MySQL-specific (seperti FIELD) di SQLite memory DB
        Route::middleware(['web', 'auth'])->get('/_test_navbar', function () {
            return view('layouts.app');
        });
    }

    /**
     * Skenario 1: Guest (pengguna belum login) mengakses landing page.
     * Navbar hanya menampilkan menu dasar: login, register, dan link publik.
     */
    public function test_guest_navbar_shows_landing_page_options(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // Assert bahwa guest melihat menu publik/landing page
        $response->assertSee('Masuk'); // Tombol login
        $response->assertSee('Daftar'); // Tombol signup
        $response->assertSee('Untuk Siapa'); // Link landing page
        
        // Assert guest tidak melihat menu sidebar yang diproteksi login
        $response->assertDontSee('Jadwal Konseling');
        $response->assertDontSee('Dompet & Pencairan');
        $response->assertDontSee('Riwayat Sesi');
    }

    /**
     * Skenario 2: Regular User (Mahasiswa/Klien) login dan melihat menu navbar yang sesuai.
     */
    public function test_regular_user_navbar_shows_client_options(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/_test_navbar');

        $response->assertStatus(200);

        // Menampilkan menu klien reguler
        $response->assertSee('Homepage');
        $response->assertSee('Konsultasi');
        $response->assertSee('Riwayat Sesi');
        $response->assertSee('Mood Tracker');
        $response->assertSee('Forum');
        $response->assertSee('Jurnal');
        $response->assertSee('Artikel');

        // Tidak menampilkan menu admin & konselor
        $response->assertDontSee('Kelola Transaksi');
        $response->assertDontSee('Rekrutmen Konselor');
        $response->assertDontSee('Ketersediaan Waktu');
        $response->assertDontSee('Dompet & Pencairan');
    }

    /**
     * Skenario 3: Admin login dan melihat menu sidebar/navbar admin yang sesuai.
     */
    public function test_admin_navbar_shows_admin_options(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/_test_navbar');

        $response->assertStatus(200);

        // Menampilkan menu admin
        $response->assertSee('Dashboard');
        $response->assertSee('Rekrutmen Konselor');
        $response->assertSee('Laporan & Moderasi', false);
        $response->assertSee('Spesialisasi');
        $response->assertSee('Kelola Artikel');
        $response->assertSee('FAQ');
        $response->assertSee('Kelola Transaksi');

        // Tidak menampilkan menu khusus user reguler / konselor
        $response->assertDontSee('Mood Tracker');
        $response->assertDontSee('Ketersediaan Waktu');
        $response->assertDontSee('Dompet & Pencairan');
    }

    /**
     * Skenario 4: Konselor login dan melihat menu sidebar/navbar konselor yang sesuai.
     */
    public function test_counselor_navbar_shows_counselor_options(): void
    {
        $counselor = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($counselor)->get('/_test_navbar');

        $response->assertStatus(200);

        // Menampilkan menu konselor
        $response->assertSee('Dashboard');
        $response->assertSee('Jadwal Konseling');
        $response->assertSee('Ketersediaan Waktu');
        $response->assertSee('Daftar Pasien');
        $response->assertSee('Dompet & Pencairan', false);

        // Tidak menampilkan menu admin / user reguler
        $response->assertDontSee('Kelola Transaksi');
        $response->assertDontSee('Rekrutmen Konselor');
        $response->assertDontSee('Mood Tracker');
    }
}
