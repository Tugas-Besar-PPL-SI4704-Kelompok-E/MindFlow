<?php

namespace Tests\Browser;

use App\Models\ProfilKonselor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI28ProfilDetailKonselorTest extends DuskTestCase
{
    use DatabaseMigrations;

    


    public function test_menampilkan_profil_detail_konselor_dengan_biografi_dan_keahlian()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create([
                'biografi' => 'Konselor profesional dengan pengalaman 5 tahun',
                'keahlian' => 'Terapi Kognitif Perilaku, Konseling Keluarga'
            ]);
            $user = User::factory()->create();

            $browser->loginAs($user)
                    ->visit('/konseling')
                    ->pause(1000)
                    ->assertSee($konselor->nama)
                    
                    ->clickLink('Pilih Sesi')
                    ->pause(1000)
                    ->assertPathIs("/konseling/{$konselor->profil_konselor_id}")
                    ->assertSee($konselor->nama)
                    ->assertSee($konselor->biografi);

            foreach (explode(',', $konselor->keahlian) as $keahlian) {
                $browser->assertSee(trim($keahlian));
            }
            
            
            $browser->assertSee('Konfirmasi Pembayaran');
        });
    }

    public function test_menampilkan_profil_konselor_dengan_data_tidak_lengkap()
    {
        $this->browse(function (Browser $browser) {
            $konselor = ProfilKonselor::factory()->create([
                'biografi' => '',
                'keahlian' => ''
            ]);
            $user = User::factory()->create();

            $browser->loginAs($user)
                    ->visit('/konseling')
                    ->pause(1000)
                    ->clickLink('Pilih Sesi')
                    ->pause(1000)
                    ->assertPathIs("/konseling/{$konselor->profil_konselor_id}")
                    ->assertSee($konselor->nama)
                    
                    ->assertSee('Informasi belum tersedia')
                    
                    ->assertSee('Konfirmasi Pembayaran');
        });
    }
}
