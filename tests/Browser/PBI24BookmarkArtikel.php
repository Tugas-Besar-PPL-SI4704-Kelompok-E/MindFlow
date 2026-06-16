<?php

namespace Tests\Browser;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI24BookmarkArtikel extends DuskTestCase
{
    



    public function test_menguji_fungsionalitas_bookmark_artikel(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::first();
            $artikelId = 1; 
            $artikel = Artikel::find($artikelId);

            
            $artikel->bookmarks()->where('user_id', $user->id)->delete();

            $browser->loginAs($user)
                    ->visit('/artikel') 
                    ->waitFor('#artikel-card-' . $artikelId) 
                    ->click('#artikel-card-' . $artikelId . ' button') 
                    ->pause(1500) 
                    
                    ->assertPresent('#artikel-card-' . $artikelId . ' button.text-\\[\\#A881C2\\]')
                    ->clickLink('Bookmark Saya') 
                    ->pause(1000)
                    ->assertPathIs('/artikel/bookmarks') 
                    ->assertSee($artikel->judul); 
        });
    }

    



    public function test_menguji_auth_pada_fitur_bookmark(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->logout() 
                    ->visit('/artikel/bookmarks') 
                    ->assertPathIs('/login'); 
        });
    }
}
