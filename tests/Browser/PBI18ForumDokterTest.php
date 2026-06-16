<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI18ForumDokterTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

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

    
    public function test_posting_forum_positif_dokter(): void
    {
        $user = User::where('email', 'rania@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    ->type('content', 'Postingan edukasi dokter via Dusk ' . now()->format('Y-m-d H:i:s'))
                    ->press('Posting')
                    ->pause(2000)
                    ->assertPathIs('/forum')
                    ->assertSee('DOKTER');
        });
    }

    
    public function test_posting_forum_negatif_dokter(): void
    {
        $user = User::where('email', 'rania@example.com')->first();

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
}
