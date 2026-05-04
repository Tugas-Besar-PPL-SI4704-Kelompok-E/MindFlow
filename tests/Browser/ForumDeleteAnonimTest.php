<?php

namespace Tests\Browser;

use App\Models\Thread;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForumDeleteAnonimTest extends DuskTestCase
{
    /**
     * Test PBI: Hapus Postingan Forum (Positif - Anonim)
     *
     * Skenario: User anonim login, lalu menghapus postingannya sendiri
     *           yang sudah ada (thread existing milik apis@gmail.com).
     * Ekspektasi: Postingan berhasil dihapus, redirect ke /forum,
     *             dan thread sudah tidak ada di database.
     */
    public function test_hapus_postingan_positif_anonim(): void
    {
        $this->browse(function (Browser $browser) {

            // ── Persiapan: ambil thread existing milik apis@gmail.com ──────
            $user   = User::where('email', 'apis@gmail.com')->first();
            $thread = Thread::where('user_id', $user->id)->latest()->first();

            // Fallback: jika tidak ada thread, buat via DB
            if (!$thread) {
                $thread = Thread::create([
                    'user_id'      => $user->id,
                    'content'      => 'hi all',
                    'is_anonymous' => true,
                ]);
            }

            $threadId = $thread->id;

            // ── Step 1: Login sebagai user anonim ──────────────────────────
            $browser->visit('/login')
                    ->type('email', 'apis@gmail.com')
                    ->type('password', '12345678')
                    ->press('Masuk')
                    ->pause(2000);

            // ── Step 2: Buka halaman forum ─────────────────────────────────
            $browser->visit('/forum')
                    ->assertPathIs('/forum')
                    ->pause(1500);

            // ── Step 3: Buka dropdown pada thread milik sendiri via JS ─────
            $browser->script(
                "document.getElementById('dropdown-{$threadId}').classList.remove('hidden');"
            );

            $browser->pause(500)
                    ->scrollIntoView("#dropdown-{$threadId}");

            // ── Step 4: Submit form hapus via JS (bypass confirm dialog) ───
            $browser->script("
                var form = document.querySelector('#dropdown-{$threadId} form');
                if (form) { form.submit(); }
            ");

            $browser->pause(2500);

            // ── Ekspektasi: tetap di /forum setelah hapus ──────────────────
            $browser->assertPathIs('/forum');

            // Verifikasi DB: thread sudah benar-benar terhapus
            $this->assertNull(
                Thread::find($threadId),
                'Thread masih ada di database setelah dihapus.'
            );
        });
    }

    /**
     * Test PBI: Hapus Postingan Forum (Negatif - Anonim)
     *
     * Skenario: User anonim login dan membuka dropdown postingan milik user lain (konselor).
     * Ekspektasi: Tombol "Hapus Post" TIDAK muncul pada postingan orang lain —
     *             hanya tombol "Laporkan" yang tersedia.
     */
    public function test_hapus_postingan_negatif_anonim(): void
    {
        $this->browse(function (Browser $browser) {

            // ── Persiapan: pastikan ada thread milik konselor ──────────────
            $konselor       = User::where('role', 'konselor')->first();
            $threadKonselor = Thread::where('user_id', $konselor->id)->latest()->first();

            if (!$threadKonselor) {
                $threadKonselor = Thread::create([
                    'user_id'      => $konselor->id,
                    'content'      => 'Thread konselor untuk test hapus negatif anonim',
                    'is_anonymous' => false,
                ]);
            }

            // ── Step 1: Login sebagai user anonim ──────────────────────────
            $browser->visit('/login')
                    ->type('email', 'apis@gmail.com')
                    ->type('password', '12345678')
                    ->press('Masuk')
                    ->pause(2000);

            // ── Step 2: Buka halaman forum ─────────────────────────────────
            $browser->visit('/forum')
                    ->assertPathIs('/forum')
                    ->pause(1000);

            // ── Step 3: Buka dropdown thread milik konselor via JS ─────────
            $browser->script(
                "document.getElementById('dropdown-{$threadKonselor->id}').classList.remove('hidden');"
            );

            $browser->pause(500)
                    ->scrollIntoView("#dropdown-{$threadKonselor->id}");

            // ── Ekspektasi: Tombol "Hapus Post" TIDAK ada di dropdown ──────
            // User anonim hanya boleh melihat "Laporkan" pada post orang lain
            $browser->within("#dropdown-{$threadKonselor->id}", function ($dropdown) {
                $dropdown->assertDontSee('Hapus Post')
                         ->assertSee('Laporkan');
            });
        });
    }
}
