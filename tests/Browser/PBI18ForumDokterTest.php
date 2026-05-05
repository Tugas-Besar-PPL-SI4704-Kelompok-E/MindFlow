<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI18ForumDokterTest extends DuskTestCase
{
    /**
     * Test PBI-18: Posting Forum (Positif - Dokter/Konselor)
     */
    public function test_posting_forum_positif_dokter(): void
    {
        $this->browse(function (Browser $browser) {
            // Login terlebih dahulu sebagai konselor/dokter
            // Email 'rania@example.com' merupakan seeder untuk konselor
            $browser->visit('/login')
                    ->type('email', 'rania@example.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->pause(2000) // Tunggu proses login selesai
                    
                    // Skenario 1: Buka /forum
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    
                    // Skenario 2: Isi input content
                    ->type('content', 'Ini adalah postingan edukasi test dari dokter menggunakan Laravel Dusk pada ' . now()->format('Y-m-d H:i:s'))
                    
                    // Skenario 3: Klik tombol Posting
                    ->press('Posting')
                    ->pause(2000) // Tunggu proses posting selesai
                    
                    // Ekspektasi: Path saat ini /forum dan muncul postingan baru dengan label Dokter
                    ->assertPathIs('/forum')
                    ->assertSee('DOKTER');
        });
    }

    /**
     * Test PBI-18: Posting Forum (Negatif - Dokter/Konselor)
     */
    public function test_posting_forum_negatif_dokter(): void
    {
        $this->browse(function (Browser $browser) {
            // Karena session browser Dusk mungkin me-reset data login antar-method, kita login lagi:
            $browser->visit('/login')
                    ->type('email', 'rania@example.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->pause(2000)

            // Langkah 1: Buka /forum
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    
            // Langkah 2: Kosongkan input content
                    ->clear('#thread-content')
                    
            // Langkah 3: Klik tombol Posting
                    ->press('Posting')
                    ->pause(1500);
                    
            // Ekspektasi: Postingan tidak terbit, tetap di halaman form
            $browser->assertPathIs('/forum');
        });
    }
}
