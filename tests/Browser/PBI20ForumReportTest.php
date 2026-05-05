<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI20ForumReportTest extends DuskTestCase
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

    /** Test Laporan Postingan Forum (Positif - Anonim) */
    public function test_report_forum_positif_anonim(): void
    {
        $user     = User::where('email', 'asep@example.com')->first();
        $konselor = User::where('role', 'konselor')->first();
        $thread   = Thread::create([
            'user_id'      => $konselor->id,
            'content'      => 'Thread untuk ditest report oleh anonim',
            'is_anonymous' => false,
        ]);

        $this->browse(function (Browser $browser) use ($user, $thread) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->script("document.getElementById('report-post-{$thread->id}').classList.remove('hidden');");

            $browser->pause(500)
                    ->scrollIntoView("#report-post-{$thread->id}")
                    ->with("#report-post-{$thread->id}", function ($form) {
                        $form->type('reason', 'spam')
                             ->press('Kirim');
                    })
                    ->pause(2000)
                    ->assertPathIs('/forum');
        });
    }

    /** Test Laporan Postingan Forum (Negatif - Anonim) */
    public function test_report_forum_negatif_anonim(): void
    {
        $user     = User::where('email', 'asep@example.com')->first();
        $konselor = User::where('role', 'konselor')->first();
        $thread   = Thread::create([
            'user_id'      => $konselor->id,
            'content'      => 'Thread untuk ditest report negatif oleh anonim',
            'is_anonymous' => false,
        ]);

        $this->browse(function (Browser $browser) use ($user, $thread) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->script("document.getElementById('report-post-{$thread->id}').classList.remove('hidden');");

            $browser->pause(500)
                    ->scrollIntoView("#report-post-{$thread->id}")
                    ->with("#report-post-{$thread->id}", function ($form) {
                        $form->clear('reason')
                             ->press('Kirim');
                    })
                    ->pause(1500)
                    ->assertPathIs('/forum');
        });
    }
}
