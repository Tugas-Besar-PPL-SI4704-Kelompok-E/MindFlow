<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI21HalamanArtikel extends DuskTestCase
{
    




    public function test_menguji_fungsionalitas_halaman_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::first();

            $browser->loginAs($user)
                    ->visit('/home') 
                    ->visit('/artikel') 
                    ->assertPathIs('/artikel'); 
        });
    }

    



    public function test_menguji_auth_pada_fitur_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout() 
                    ->visit('/artikel') 
                    ->assertPathIs('/login'); 
        });
    }
}
