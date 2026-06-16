<?php

namespace Tests\Browser;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI22DetailArtikel extends DuskTestCase
{
    



    public function test_menguji_fungsionalitas_detail_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $artikel = Artikel::published()->first();

            $browser->loginAs($user)
                    ->visit('/home') 
                    ->visit('/artikel') 
                    ->waitFor('#artikel-card-' . $artikel->artikel_id) 
                    ->click('#artikel-card-' . $artikel->artikel_id) 
                    ->waitFor('#artikelModal.show') 
                    ->assertVisible('#artikelModal.show'); 
        });
    }

    



    public function test_menguji_fungsionalitas_isi_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $artikel = Artikel::published()->first();

            $browser->loginAs($user)
                    ->visit('/home') 
                    ->visit('/artikel') 
                    ->waitFor('#artikel-card-' . $artikel->artikel_id)
                    ->click('#artikel-card-' . $artikel->artikel_id) 
                    ->waitFor('#artikelModal.show') 
                    ->click('#artikelModalReadBtn') 
                    ->assertPathIs('/artikel/' . $artikel->artikel_id); 
        });
    }

    



    public function test_menguji_auth_pada_fitur_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $artikel = Artikel::published()->first();

            $browser->logout() 
                    ->visit('/artikel/' . $artikel->artikel_id) 
                    ->assertPathIs('/login'); 
        });
    }
}
