<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SaranTest extends DuskTestCase
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

    public function testPertolonganPertamaMunculSaatMoodBuruk(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->click('a[href*="/mood-tracker/singkat"]')
                 ->pause(1000)
                 ->script("document.querySelector('.emoji-btn[data-value=\"2\"]').click();");
                 
            $browser->pause(500)
                 ->press('Simpan Aktivitas')
                 ->pause(1500);

            
            $browser->waitFor('#badMoodModal')
                 ->click('#btnSkipModal')
                 ->pause(1500)
                 ->assertPathIs('/mood-tracker')
                 ->assertSee('Pertolongan Pertama')
                 ->screenshot('TC_Saran_001_Pass');
        });
    }

    public function testPertolonganPertamaTidakMunculSaatMoodBaik(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->click('a[href*="/mood-tracker/singkat"]')
                 ->pause(1000)
                 ->script("document.querySelector('.emoji-btn[data-value=\"9\"]').click();");
                 
            $browser->pause(500)
                 ->press('Simpan Aktivitas')
                 ->pause(1500)
                 ->visit('/mood-tracker')
                 ->pause(1000)
                 ->assertDontSee('Pertolongan Pertama')
                 ->screenshot('TC_Saran_002_Pass');
        });
    }

    public function testRekomendasiPersonalDass21(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->click('a[href*="/mood-tracker/mendalam"]')
                 ->pause(1000)
                 ->with('#dass21Form', function ($form) {
                     for ($i = 1; $i <= 21; $i++) {
                         $form->script("document.querySelector('input[name=\"responses[{$i}][score]\"][value=\"3\"]').click();");
                     }
                 })
                 ->press('Kirim Evaluasi')
                 ->pause(2000)
                 ->assertSee('Rekomendasi & Saran Personal')
                 ->screenshot('TC_Saran_003_Pass');
        });
    }
}
