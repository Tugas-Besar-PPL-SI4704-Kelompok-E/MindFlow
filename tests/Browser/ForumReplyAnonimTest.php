<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumReplyAnonimTest extends DuskTestCase
{
    /**
     * Test Komentar/Reply Forum (Positif - Anonim)
     */
    public function test_reply_forum_positif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            // Pastikan ada minimal 1 thread untuk direply
            $thread = Thread::first();
            if (!$thread) {
                $user = User::where('email', 'apis@gmail.com')->first();
                $thread = Thread::create([
                    'user_id' => $user->id,
                    'content' => 'Thread untuk test reply',
                    'is_anonymous' => true,
                ]);
            }

            // Login terlebih dahulu sebagai user anonim
            $browser->visit('/login')
                    ->type('email', 'apis@gmail.com')
                    ->type('password', '12345678')
                    ->press('Masuk')
                    ->pause(2000)
                    
                    // Buka halaman detail thread
                    ->visit('/forum/' . $thread->id)
                    ->assertPathIs('/forum/' . $thread->id)
                    
                    // Isi input komentar/reply
                    ->with('.pt-6 form', function ($form) {
                        $form->type('content', 'hi')
                             ->press('Balas');
                    })
                    ->pause(2000) // Tunggu proses selesai
                    
                    // Ekspektasi: Muncul komentar baru di halaman thread
                    ->assertPathIs('/forum/' . $thread->id)
                    ->assertSee('hi');
        });
    }

    /**
     * Test Komentar/Reply Forum (Negatif - Anonim)
     */
    public function test_reply_forum_negatif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            $thread = Thread::first();

            $browser->visit('/login')
                    ->type('email', 'apis@gmail.com')
                    ->type('password', '12345678')
                    ->press('Masuk')
                    ->pause(2000)

                    // Buka halaman detail thread
                    ->visit('/forum/' . $thread->id)
                    ->assertPathIs('/forum/' . $thread->id)
                    
                    // Kosongkan input komentar/reply (Negative case)
                    ->with('.pt-6 form', function ($form) {
                        $form->clear('content')
                             ->press('Balas');
                    })
                    ->pause(1500); // Tunggu sebentar
                    
            // Ekspektasi: Komentar tidak terkirim, path tetap di halaman thread
            $browser->assertPathIs('/forum/' . $thread->id);
        });
    }
}
