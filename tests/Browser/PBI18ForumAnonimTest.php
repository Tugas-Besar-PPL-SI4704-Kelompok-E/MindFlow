<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI18ForumAnonimTest extends DuskTestCase
{
    use DatabaseMigrations;

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

    
    public function test_posting_forum_positif_anonim(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->type('content', 'Postingan anonim via Dusk ' . now()->format('Y-m-d H:i:s'))
                    ->press('Posting')
                    ->pause(2000)
                    ->assertPathIs('/forum')
                    ->assertSee('Anonim');
        });
    }

    
    public function test_posting_forum_negatif_anonim(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->clear('#thread-content')
                    ->press('Posting')
                    ->pause(1500)
                    ->assertPathIs('/forum');
        });
    }

    
    public function test_hapus_postingan_positif_anonim(): void
    {
        $user   = User::where('email', 'asep@example.com')->first();
        $thread = Thread::create([
            'user_id'      => $user->id,
            'content'      => '[TEST] Thread hapus anonim - ' . now()->timestamp,
            'is_anonymous' => true,
        ]);
        $threadId = $thread->id;

        $this->browse(function (Browser $browser) use ($user, $threadId) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->pause(1500);

            $browser->script(
                "document.getElementById('dropdown-{$threadId}').classList.remove('hidden');"
            );

            $browser->pause(500)
                    ->scrollIntoView("#dropdown-{$threadId}");

            $browser->script("
                var form = document.getElementById('deleteConfirmForm');
                if (form) {
                    form.action = '/forum/" . $threadId . "';
                    form.submit();
                }
            ");

            $browser->pause(2500)
                    ->assertPathIs('/forum');
        });

        $this->assertNull(Thread::find($threadId));
    }

    
    public function test_hapus_postingan_negatif_anonim(): void
    {
        $user     = User::where('email', 'asep@example.com')->first();
        $konselor = User::where('role', 'konselor')->first();
        $threadKonselor = Thread::create([
            'user_id'      => $konselor->id,
            'content'      => 'Thread konselor untuk test hapus negatif anonim',
            'is_anonymous' => false,
        ]);

        $this->browse(function (Browser $browser) use ($user, $threadKonselor) {
            $browser->loginAs($user)
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
