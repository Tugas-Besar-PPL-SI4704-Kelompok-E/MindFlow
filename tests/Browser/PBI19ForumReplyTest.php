<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI19ForumReplyTest extends DuskTestCase
{
    /**
     * Pastikan akun dummy selalu ada sebelum test dijalankan.
     */
    protected function setUp(): void
    {
        parent::setUp();

        User::firstOrCreate(
            ['email' => 'asep@example.com'],
            [
                'nama_asli'    => 'Asep',
                'nama_samaran' => 'Asep',
                'password'     => \Illuminate\Support\Facades\Hash::make('password'),
                'role'         => 'user',
                'status'       => 'approved',
            ]
        );
    }

    /**
     * Test Komentar/Reply Forum (Positif - Anonim)
     */
    public function test_reply_forum_positif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            // Pastikan ada minimal 1 thread untuk direply
            $thread = Thread::first();
            if (!$thread) {
                $user = User::where('email', 'asep@example.com')->first();
                $thread = Thread::create([
                    'user_id' => $user->id,
                    'content' => 'Thread untuk test reply',
                    'is_anonymous' => true,
                ]);
            }

            // Login terlebih dahulu sebagai user anonim
            $browser->visit('/login')
                    ->type('email', 'asep@example.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->pause(2000)
                    
                    // Buka halaman detail thread
                    ->visit('/forum/' . $thread->id)
                    ->assertPathIs('/forum/' . $thread->id)
                    
                    // Isi input komentar/reply
                    ->with('.pt-6 form', function ($form) {
                        $form->type('content', 'Thread untuk test reply')
                             ->press('Balas');
                    })
                    ->pause(2000) // Tunggu proses selesai
                    
                    // Ekspektasi: Muncul komentar baru di halaman thread
                    ->assertPathIs('/forum/' . $thread->id)
                    ->assertSee('Thread untuk test reply');
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
                    ->type('email', 'asep@example.com')
                    ->type('password', 'password')
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
