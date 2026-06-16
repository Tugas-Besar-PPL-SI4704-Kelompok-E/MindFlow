<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PemeriksaanTest extends DuskTestCase
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

    public function testMendalam1(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->assertSee('Pemeriksaan Singkat')
                 ->assertSee('Pemeriksaan Mendalam')
                 ->click('a[href*="/mood-tracker/mendalam"]')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/mendalam')
                 ->with('#dass21Form', function ($form) {
                     for ($i = 1; $i <= 21; $i++) {
                         $form->script("document.querySelector('input[name=\"responses[{$i}][score]\"][value=\"0\"]').click();");
                  }
                 })
                 ->press('Kirim Evaluasi')
                 ->pause(2000)
                 ->assertSee('Hasil Asesmen DASS-21')
                 ->assertSee('Tingkat Depresi')
                 ->assertSee('Tingkat Kecemasan')
                 ->assertSee('Tingkat Stres')
                 ->screenshot('Mendalam1');
        });
    }

    public function testMendalam2(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->click('a[href*="/mood-tracker/mendalam"]')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/mendalam')
                 ->with('#dass21Form', function ($form) {
                     for ($i = 1; $i <= 20; $i++) {
                         $form->script("document.querySelector('input[name=\"responses[{$i}][score]\"][value=\"1\"]').click();");
                     }
                 })
                 ->press('Kirim Evaluasi')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/mendalam')
                 ->screenshot('Mendalam2');
        });
    }

    public function testOpenQuestion1(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->click('a[href*="/mood-tracker/singkat"]')
                 ->pause(1000)
                 ->assertSee('Bagaimana perasaanmu hari ini?')
                 ->script("document.querySelector('.emoji-btn[data-value=\"3\"]').click();");
                 
            $browser->pause(500)
                 ->press('Simpan Aktivitas')
                 ->pause(1000)
                 ->assertSee('Sepertinya harimu berat')
                 ->press('Ya, Ceritakan')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/open-question')
                 ->type('#openAnswer', 'Hari ini terasa sangat berat dan saya merasa sedikit cemas akan banyak hal.')
                 ->pause(500)
                 ->press('Simpan Catatan')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->assertSee('Terima kasih sudah bercerita. Jawabanmu telah tersimpan dengan aman.')
                 ->screenshot('OpenQuestion1');
        });
    }

    public function testOpenQuestion2(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->click('a[href*="/mood-tracker/singkat"]')
                 ->pause(1000)
                 ->assertSee('Bagaimana perasaanmu hari ini?')
                 ->script("document.querySelector('.emoji-btn[data-value=\"2\"]').click();");
                 
            $browser->pause(500)
                 ->press('Simpan Aktivitas')
                 ->pause(1000)
                 ->assertSee('Sepertinya harimu berat')
                 ->press('Ya, Ceritakan')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/open-question')
                 ->assertValue('#openAnswer', '')
                 ->script("document.getElementById('submitBtn').click();");
                 
            $browser->pause(1000)
                 ->assertPathIs('/mood-tracker/open-question')
                 ->screenshot('OpenQuestion2');
      });
    }

    public function testSingkat1(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->click('a[href*="/mood-tracker/singkat"]')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/singkat')
                 ->assertSee('Bagaimana perasaanmu hari ini?')
                 ->script("document.querySelector('.emoji-btn[data-value=\"8\"]').click();");
                 
            $browser->pause(500)
                 ->press('Simpan Aktivitas')
                 ->pause(1500)
                 ->assertPathIs('/mood-tracker')
                 ->assertSee('Mood berhasil disimpan!')
                 ->screenshot('Singkat1');
        });
    }

    public function testSingkat2(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->click('a[href*="/mood-tracker/singkat"]')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/singkat')
                 ->assertSee('Bagaimana perasaanmu hari ini?')
                 ->script("document.getElementById('submitBtn').click();");
                 
            $browser->pause(1000)
                 ->assertPathIs('/mood-tracker/singkat')
                 ->screenshot('Singkat2');
        });
    }

    public function testPoin1(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->click('a[href*="/mood-tracker/mendalam"]')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/mendalam')
                 ->with('#dass21Form', function ($form) {
                     for ($i = 1; $i <= 21; $i++) {
                         $form->script("document.querySelector('input[name=\"responses[{$i}][score]\"][value=\"3\"]').click();");
                     }
                 })
                 ->press('Kirim Evaluasi')
                 ->pause(2000)
                 ->assertSee('Hasil Asesmen DASS-21')
                 ->assertSee('Sangat Berat')
                 ->screenshot('Poin1');
        });
    }

    public function testPoin2(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->assertPathIs('/home')
                 ->clickLink('Mood Tracker')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker')
                 ->click('a[href*="/mood-tracker/mendalam"]')
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/mendalam')
                 ->with('#dass21Form', function ($form) {
                     $form->script("document.getElementById('dass21Form').submit();");
                 })
                 ->pause(1000)
                 ->assertPathIs('/mood-tracker/mendalam')
                 ->screenshot('Poin2');
        });
    }
}