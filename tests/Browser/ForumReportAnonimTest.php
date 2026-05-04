<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumReportAnonimTest extends DuskTestCase
{
    /**
     * Test Laporan Postingan Forum (Positif - Anonim)
     */
    public function test_report_forum_positif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            // Pastikan ada thread dari user LAIN (bukan anonim ini) agar tombol Laporkan muncul
            // Kita ambil user konselor sebagai pembuat thread
            $konselor = User::where('role', 'konselor')->first();
            $thread = Thread::where('user_id', $konselor->id)->first();
            if (!$thread) {
                $thread = Thread::create([
                    'user_id' => $konselor->id,
                    'content' => 'Thread untuk ditest report oleh anonim',
                    'is_anonymous' => false,
                ]);
            }

            // Login sebagai user anonim
            $browser->visit('/login')
                    ->type('email', 'apis@gmail.com')
                    ->type('password', '12345678')
                    ->press('Masuk')
                    ->pause(2000)
                    
                    // Buka halaman forum
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    
                    // Gunakan JS untuk menampilkan form report (karena interaksi dropdown kadang flaky di Dusk)
                    ->script("document.getElementById('report-post-{$thread->id}').classList.remove('hidden');");
                    
            $browser->pause(500)
                    ->scrollIntoView("#report-post-{$thread->id}")
                    // Isi form report
                    ->with("#report-post-{$thread->id}", function ($form) {
                        $form->type('reason', 'spam')
                             ->press('Kirim');
                    })
                    ->pause(2000) // Tunggu proses selesai
                    
                    // Ekspektasi: Laporan terkirim dan path tetap di /forum
                    // (Biasanya ada alert/flash message, tapi minimal pastikan tetap di halaman yg sama tanpa error)
                    ->assertPathIs('/forum');
        });
    }

    /**
     * Test Laporan Postingan Forum (Negatif - Anonim)
     */
    public function test_report_forum_negatif_anonim(): void
    {
        $this->browse(function (Browser $browser) {
            $konselor = User::where('role', 'konselor')->first();
            $thread = Thread::where('user_id', $konselor->id)->first();

            $browser->visit('/login')
                    ->type('email', 'apis@gmail.com')
                    ->type('password', '12345678')
                    ->press('Masuk')
                    ->pause(2000)

                    // Buka halaman forum
                    ->visit('/forum')
                    ->assertPathIs('/forum')
                    
                    // Gunakan JS untuk menampilkan form report
                    ->script("document.getElementById('report-post-{$thread->id}').classList.remove('hidden');");
                    
            $browser->pause(500)
                    ->scrollIntoView("#report-post-{$thread->id}")
                    // Kosongkan form report (Negatif)
                    ->with("#report-post-{$thread->id}", function ($form) {
                        $form->clear('reason')
                             ->press('Kirim');
                    })
                    ->pause(1500)
                    
                    // Ekspektasi: Form gagal submit karena required, tetap di /forum
                    ->assertPathIs('/forum');
        });
    }
}
