<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI27FilterKonselorTest extends DuskTestCase
{
    use DatabaseMigrations;

    


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
                    ->pause(3000)
                    ->assertSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama)
                    ->assertDontSee($konselor3->nama);
        });
    }

    













    public function test_menampilkan_pesan_konselor_tidak_ditemukan_ketika_filter_tidak_ada_hasil()
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
                    
                    
                    
                    ->visit('/konseling?spesialisasi=Terapi Keluarga')
                    ->pause(2000)
                    
                    
                    ->assertSee('Konselor Tidak Ditemukan')
                    ->assertSee('Maaf, saat ini belum ada konselor yang tersedia untuk kategori tersebut.')
                    
                    
                    ->assertDontSee($konselor1->nama)
                    ->assertDontSee($konselor2->nama)
                    ->assertDontSee($konselor3->nama);
        });
    }

    






    public function test_user_dapat_membatalkan_filter_dan_kembali_ke_daftar_lengkap()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);

            $browser->loginAs($user)
                    
                    ->visit('/konseling?spesialisasi=Terapi Keluarga')
                    ->pause(2000)
                    ->assertSee('Konselor Tidak Ditemukan')
                    
                    
                    ->click('a[href="' . route('konseling.index') . '"]')
                    ->pause(3000)
                    ->assertPathIs('/konseling')
                    
                    
                    ->assertSee($konselor1->nama)
                    ->assertSee($konselor2->nama);
        });
    }

    



    public function test_user_dapat_reset_filter_menggunakan_tombol_x()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
            $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);

            $browser->loginAs($user)
                    
                    ->visit('/konseling?spesialisasi=Terapi Keluarga')
                    ->pause(2000)
                    ->assertSee('Konselor Tidak Ditemukan')
                    
                    
                    ->click('a[href="' . route('konseling.index') . '"]')
                    ->pause(3000)
                    ->assertPathIs('/konseling')
                    
                    
                    ->assertSee($konselor1->nama)
                    ->assertSee($konselor2->nama);
        });
    }
}
