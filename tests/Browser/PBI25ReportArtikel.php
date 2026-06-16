<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Artikel;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI25ReportArtikel extends DuskTestCase
{
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

    



    public function test_tc_rpta_001_report_artikel_positif(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        
        $artikel = Artikel::published()->firstOrFail();

        $this->browse(function (Browser $browser) use ($user, $artikel) {
            $browser->loginAs($user)
                    ->visit('/home') 
                    ->assertPathIs('/home')
                    
                    ->visit('/artikel')
                    ->assertPathIs('/artikel')
                    
                    ->waitFor("#artikel-card-{$artikel->artikel_id}", 5)
                    ->click("#artikel-card-{$artikel->artikel_id}")
                    
                    ->waitFor('#artikelModalReadBtn', 5)
                    ->click('#artikelModalReadBtn')
                    ->assertPathIs("/artikel/{$artikel->artikel_id}")
                    
                    ->waitFor('#btn-report-artikel', 5)
                    ->click('#btn-report-artikel')
                    
                    ->waitFor('#reportModal', 5)
                    ->assertVisible('#reportModal')
                    
                    ->type('reason', 'Spamming konten yang tidak relevan.')
                    ->press('Kirim Laporan')
                    
                    ->pause(1500)
                    ->assertSee('Laporan artikel berhasil dikirim.');
        });
    }

    



    public function test_tc_rpta_002_report_artikel_negatif_kosong(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        $artikel = Artikel::published()->firstOrFail();

        $this->browse(function (Browser $browser) use ($user, $artikel) {
            $browser->loginAs($user)
                    ->visit("/artikel/{$artikel->artikel_id}")
                    ->waitFor('#btn-report-artikel', 5)
                    ->click('#btn-report-artikel')
                    
                    ->waitFor('#reportModal', 5)
                    
                    ->clear('reason')
                    ->press('Kirim Laporan');

            $errorMessage = $browser->script("return document.querySelector('textarea[name=reason]').validationMessage;")[0];
            $this->assertNotEmpty($errorMessage);
        });
    }
}
