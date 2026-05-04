<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumAdminTest extends DuskTestCase
{
    /**
     * Test PBI-18: Posting Forum (Positif - Admin)
     */
    public function test_posting_forum_positif_admin(): void
    {
        $this->browse(function (Browser $browser) {
            // Login terlebih dahulu sebagai admin
            $browser->visit('/login')
                    ->type('email', 'admin@mindflow.id')
                    ->type('password', 'admin123')
                    ->press('Masuk')
                    ->pause(2000) 
                    
                    // Skenario 1: Buka /forum
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    
                    // Skenario 2: Isi input content
                    ->type('content', 'Ini adalah pengumuman test dari admin menggunakan Laravel Dusk pada ' . now()->format('Y-m-d H:i:s'))
                    
                    // Skenario 3: Klik tombol Posting
                    ->press('Posting')
                    ->pause(2000)
                    
                    // Ekspektasi: Path saat ini /forum dan muncul postingan baru dengan label ADMIN
                    ->assertPathIs('/forum')
                    ->assertSee('ADMIN');
        });
    }

    /**
     * Test PBI-18: Posting Forum (Negatif - Admin)
     */
    public function test_posting_forum_negatif_admin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@mindflow.id')
                    ->type('password', 'admin123')
                    ->press('Masuk')
                    ->pause(2000)

            // Langkah 1: Buka /forum
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    
            // Langkah 2: Kosongkan input content
                    ->clear('content')
                    
            // Langkah 3: Klik tombol Posting
                    ->press('Posting')
                    ->pause(1500);
                    
            // Ekspektasi: Postingan tidak terbit, tetap di halaman form
            $browser->assertPathIs('/forum');
        });
    }
}
