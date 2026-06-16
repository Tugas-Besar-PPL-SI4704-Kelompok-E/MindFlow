<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI23SearchFilterArtikel extends DuskTestCase
{
    



    public function test_menguji_fungsionalitas_search_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $browser->loginAs($user)
                    ->visit('/artikel') 
                    ->click('#artikel-search') 
                    ->type('#artikel-search', '5 Teknik') 
                    ->keys('#artikel-search', '{enter}') 
                    ->pause(1000) 
                    ->assertSee('5 Teknik Mindfulness untuk Mengurangi Stres'); 
        });
    }

    



    public function test_menguji_fungsionalitas_search_artikel_negative(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $browser->loginAs($user)
                    ->visit('/artikel') 
                    ->click('#artikel-search') 
                    ->type('#artikel-search', '6 Teknik') 
                    ->keys('#artikel-search', '{enter}') 
                    ->pause(1000)
                    ->assertSee('Artikel Tidak Ditemukan'); 
        });
    }

    



    public function test_menguji_fungsionalitas_filter_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $browser->loginAs($user)
                    ->visit('/artikel') 
                    ->click('#artikel-filter') 
                    ->select('#artikel-filter', 'Edukasi') 
                    ->pause(1000)
                    ->assertSee('Edukasi'); 
        });
    }
}
