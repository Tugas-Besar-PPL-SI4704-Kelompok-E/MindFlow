<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI19ForumReplyTest extends DuskTestCase
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
    }

    
    public function test_reply_forum_positif_anonim(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        $thread = Thread::create([
            'user_id' => $user->id,
            'content' => 'Thread untuk test reply',
            'is_anonymous' => true,
        ]);

        $this->browse(function (Browser $browser) use ($user, $thread) {
            $browser->loginAs($user)
                    ->visit('/forum/' . $thread->id)
                    ->assertPathIs('/forum/' . $thread->id)
                    ->with('.pt-6 form', function ($form) {
                        $form->type('content', 'Thread untuk test reply')
                             ->press('Balas');
                    })
                    ->pause(2000)
                    ->assertPathIs('/forum/' . $thread->id)
                    ->assertSee('Thread untuk test reply');
        });
    }

    
    public function test_reply_forum_negatif_anonim(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        $thread = Thread::create([
            'user_id' => $user->id,
            'content' => 'Thread untuk test reply negatif',
            'is_anonymous' => true,
        ]);

        $this->browse(function (Browser $browser) use ($user, $thread) {
            $browser->loginAs($user)
                    ->visit('/forum/' . $thread->id)
                    ->assertPathIs('/forum/' . $thread->id)
                    ->with('.pt-6 form', function ($form) {
                        $form->clear('content')
                             ->press('Balas');
                    })
                    ->pause(1500)
                    ->assertPathIs('/forum/' . $thread->id);
        });
    }
}
