<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI18ForumAdminTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        User::firstOrCreate(
            ['email' => 'admin@mindflow.id'],
            [
                'nama_asli'    => 'Admin MindFlow',
                'nama_samaran' => 'AdminMF',
                'password'     => Hash::make('admin123'),
                'role'         => 'admin',
                'status'       => 'approved',
            ]
        );
    }

    /** Test PBI-18: Posting Forum (Positif - Admin) */
    public function test_posting_forum_positif_admin(): void
    {
        $user = User::where('email', 'admin@mindflow.id')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->type('content', 'Pengumuman test admin via Dusk ' . now()->format('Y-m-d H:i:s'))
                    ->press('Posting')
                    ->pause(2000)
                    ->assertPathIs('/forum')
                    ->assertSee('ADMIN');
        });
    }

    /** Test PBI-18: Posting Forum (Negatif - Admin) */
    public function test_posting_forum_negatif_admin(): void
    {
        $user = User::where('email', 'admin@mindflow.id')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->clear('content')
                    ->press('Posting')
                    ->pause(1500)
                    ->assertPathIs('/forum');
        });
    }
}
