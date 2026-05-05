<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI18ForumAnonimTest extends DuskTestCase
{
    /**
     * Pastikan akun dummy selalu ada sebelum test dijalankan.
     * Aman dijalankan di device manapun — tidak akan duplikat karena pakai firstOrCreate.
     */
    protected function setUp(): void
    {
        parent::setUp();

        User::firstOrCreate(
            ['email' => 'asep@example.com'],
            [
                'nama_asli'    => 'Asep',
                'nama_samaran' => 'Asep',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'status'       => 'approved',
            ]
        );

        // Akun Konselor (Rania)
        User::firstOrCreate(
            ['email' => 'rania@example.com'],
            [
                'nama_asli'    => 'Rania',
                'nama_samaran' => 'Rania',
                'password'     => Hash::make('password'),
                'role'         => 'konselor',
                'status'       => 'approved',
            ]
        );
    }

    /**
     * Test PBI-18: Posting Forum (Positif - Anonim)
     */
    public function test_posting_forum_positif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'asep@example.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->pause(1000)

                    // Skenario 1: Buka /forum
                    ->visit('/forum')
                    ->assertPathIs('/forum')

                    // Skenario 2: Isi input content
                    ->type('content', 'Ini adalah postingan test dari user anonim menggunakan Laravel Dusk pada ' . now()->format('Y-m-d H:i:s'))

                    // Skenario 3: Klik tombol Posting
                    ->press('Posting')
                    ->pause(2000)

                    // Ekspektasi: Path saat ini /forum dan muncul label Anonim
                    ->assertPathIs('/forum')
                    ->assertSee('Anonim');
        });
    }

    /**
     * Test PBI-18: Posting Forum (Negatif - Anonim, konten kosong)
     */
    public function test_posting_forum_negatif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            // Login ulang karena session bisa reset antar-method di Dusk
            $browser->visit('/login')
                    ->type('email', 'asep@example.com')
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

            // Ekspektasi: Postingan tidak terbit, tetap di halaman forum
            $browser->assertPathIs('/forum');
        });
    }

    /**
     * Test PBI-18: Hapus Postingan Forum (Positif - Anonim)
     */
    public function test_hapus_postingan_positif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            $user   = User::where('email', 'asep@example.com')->first();
            $thread = Thread::create([
                'user_id'      => $user->id,
                'content'      => '[TEST] Thread hapus anonim - ' . now()->timestamp,
                'is_anonymous' => true,
            ]);

            $threadId = $thread->id;

            $browser->visit('/login')
                    ->type('email', 'asep@example.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->pause(2000)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->pause(1500);

            $browser->script(
                "document.getElementById('dropdown-{$threadId}').classList.remove('hidden');"
            );

            $browser->pause(500)
                    ->scrollIntoView("#dropdown-{$threadId}");

            $browser->script("
                var form = document.querySelector('#dropdown-{$threadId} form');
                if (form) { form.submit(); }
            ");

            $browser->pause(2500)
                    ->assertPathIs('/forum');

            $this->assertNull(Thread::find($threadId));
        });
    }

    /**
     * Test PBI-18: Hapus Postingan Forum (Negatif - Anonim)
     */
    public function test_hapus_postingan_negatif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            $konselor       = User::where('role', 'konselor')->first();
            $threadKonselor = Thread::where('user_id', $konselor->id)->latest()->first();

            if (!$threadKonselor) {
                $threadKonselor = Thread::create([
                    'user_id'      => $konselor->id,
                    'content'      => 'Thread konselor untuk test hapus negatif anonim',
                    'is_anonymous' => false,
                ]);
            }

            $browser->visit('/login')
                    ->type('email', 'asep@example.com')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->pause(2000)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->pause(1000);

            $browser->script(
                "document.getElementById('dropdown-{$threadKonselor->id}').classList.remove('hidden');"
            );

            $browser->pause(500)
                    ->scrollIntoView("#dropdown-{$threadKonselor->id}");

            $browser->within("#dropdown-{$threadKonselor->id}", function ($dropdown) {
                $dropdown->assertDontSee('Hapus Post')
                         ->assertSee('Laporkan');
            });
        });
    }
}
