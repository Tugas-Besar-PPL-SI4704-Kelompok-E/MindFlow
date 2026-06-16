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

        
        
        Route::middleware(['web', 'auth'])->get('/_test_navbar', function () {
            return view('layouts.app');
        });
    }

    



    public function test_guest_navbar_shows_landing_page_options(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        
        $response->assertSee('Masuk'); 
        $response->assertSee('Daftar'); 
        $response->assertSee('Untuk Siapa'); 
        
        
        $response->assertDontSee('Jadwal Konseling');
        $response->assertDontSee('Dompet & Pencairan');
        $response->assertDontSee('Riwayat Sesi');
    }

    


    public function test_regular_user_navbar_shows_client_options(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/_test_navbar');

        $response->assertStatus(200);

        
        $response->assertSee('Homepage');
        $response->assertSee('Konsultasi');
        $response->assertSee('Riwayat Sesi');
        $response->assertSee('Mood Tracker');
        $response->assertSee('Forum');
        $response->assertSee('Jurnal');
        $response->assertSee('Artikel');

        
        $response->assertDontSee('Kelola Transaksi');
        $response->assertDontSee('Rekrutmen Konselor');
        $response->assertDontSee('Ketersediaan Waktu');
        $response->assertDontSee('Dompet & Pencairan');
    }

    


    public function test_admin_navbar_shows_admin_options(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/_test_navbar');

        $response->assertStatus(200);

        
        $response->assertSee('Dashboard');
        $response->assertSee('Rekrutmen Konselor');
        $response->assertSee('Laporan & Moderasi', false);
        $response->assertSee('Spesialisasi');
        $response->assertSee('Kelola Artikel');
        $response->assertSee('FAQ');
        $response->assertSee('Kelola Transaksi');

        
        $response->assertDontSee('Mood Tracker');
        $response->assertDontSee('Ketersediaan Waktu');
        $response->assertDontSee('Dompet & Pencairan');
    }

    


    public function test_counselor_navbar_shows_counselor_options(): void
    {
        $counselor = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($counselor)->get('/_test_navbar');

        $response->assertStatus(200);

        
        $response->assertSee('Dashboard');
        $response->assertSee('Jadwal Konseling');
        $response->assertSee('Ketersediaan Waktu');
        $response->assertSee('Daftar Pasien');
        $response->assertSee('Dompet & Pencairan', false);

        
        $response->assertDontSee('Kelola Transaksi');
        $response->assertDontSee('Rekrutmen Konselor');
        $response->assertDontSee('Mood Tracker');
    }
}
