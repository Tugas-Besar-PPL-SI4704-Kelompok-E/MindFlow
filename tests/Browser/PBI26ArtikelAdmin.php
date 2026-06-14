<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Artikel;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI26ArtikelAdmin extends DuskTestCase
{
    /**
     * TC.ADM.001: Menguji fungsionalitas membaca (Read) Artikel (Positive)
     */
    public function test_tc_adm_001_read_artikel(): void
    {
        $admin = User::where('email', 'admin@mindflow.id')->firstOrFail();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->assertPathIs('/admin/dashboard')
                    
                    ->clickLink('Kelola Artikel')
                    
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Daftar Artikel');
        });
    }

    /**
     * TC.ADM.002: Menguji fungsionalitas membuat artikel (Positive)
     */
    public function test_tc_adm_002_create_artikel_positif(): void
    {
        $admin = User::where('email', 'admin@mindflow.id')->firstOrFail();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/dashboard')
                    ->assertPathIs('/admin/dashboard')
                    
                    ->visit('/admin/artikel')
                    ->assertPathIs('/admin/artikel')
                    
                    ->clickLink('Tambah Artikel')
                    
                    ->assertSee('Tambah Artikel Baru')
                    
                    ->type('judul', 'Judul Baru Artikel Admin Dusk')
                    ->select('kategori', 'Tips & Trik')
                    ->type('penerbit', 'Admin Uji Dusk')
                    ->select('status', 'published')
                    ->type('konten', 'Konten artikel baru yang dibuat lewat Laravel Dusk.')
                    
                    ->press('Simpan Artikel')
                    ->pause(1500);

            if (parse_url($browser->driver->getCurrentURL(), PHP_URL_PATH) !== '/admin/artikel') {
                $this->fail("Failed redirect on create. Page URL: " . $browser->driver->getCurrentURL() . " | Page body text: " . $browser->script("return document.body.innerText;")[0]);
            }

            $browser->assertPathIs('/admin/artikel')
                    ->assertSee('Artikel berhasil ditambahkan.');
        });
    }

    /**
     * TC.ADM.003: Menguji fungsionalitas membuat artikel - Konten Kosong (Negative)
     */
    public function test_tc_adm_003_create_artikel_negatif_kosong(): void
    {
        $admin = User::where('email', 'admin@mindflow.id')->firstOrFail();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/artikel/create')
                    ->assertSee('Tambah Artikel Baru')
                    
                    ->type('judul', 'Judul Baru Tanpa Konten')
                    ->select('kategori', 'Tips & Trik')
                    ->type('penerbit', 'Admin Uji Dusk')
                    ->select('status', 'published')
                    ->clear('konten')
                    
                    ->press('Simpan Artikel');

            $errorMessage = $browser->script("return document.querySelector('textarea[name=konten]').validationMessage;")[0];
            $this->assertNotEmpty($errorMessage);
        });
    }

    /**
     * TC.ADM.004: Menguji fungsionalitas mengubah (update) artikel (Positive)
     */
    public function test_tc_adm_004_update_artikel(): void
    {
        $admin = User::where('email', 'admin@mindflow.id')->firstOrFail();
        
        $artikel = Artikel::where('judul', '!=', 'Judul Baru Artikel Admin Dusk')->firstOrFail();

        $this->browse(function (Browser $browser) use ($admin, $artikel) {
            $browser->loginAs($admin)
                    ->visit('/admin/artikel')
                    ->assertPathIs('/admin/artikel')
                    
                    ->visit("/admin/artikel/{$artikel->artikel_id}/edit")
                    
                    ->assertSee('Edit Artikel')
                    ->assertInputValue('judul', $artikel->judul)
                    
                    ->type('judul', $artikel->judul . ' (Revisi)')
                    ->type('penerbit', 'Admin MindFlow')
                    ->type('konten', 'Konten artikel ini telah direvisi menggunakan Dusk.')
                    
                    ->press('Simpan Perubahan')
                    ->pause(1500);

            if (parse_url($browser->driver->getCurrentURL(), PHP_URL_PATH) !== '/admin/artikel') {
                $this->fail("Failed redirect on update. Page URL: " . $browser->driver->getCurrentURL() . " | Page body text: " . $browser->script("return document.body.innerText;")[0]);
            }

            $browser->assertPathIs('/admin/artikel')
                    ->assertSee('Artikel berhasil diperbarui.');
        });
    }

    /**
     * TC.ADM.005: Menguji fungsionalitas menghapus (Delete) Artikel (Positive)
     */
    public function test_tc_adm_005_delete_artikel(): void
    {
        $admin = User::where('email', 'admin@mindflow.id')->firstOrFail();
        
        $artikel = Artikel::latest()->firstOrFail();

        $this->browse(function (Browser $browser) use ($admin, $artikel) {
            $browser->loginAs($admin)
                    ->visit('/admin/artikel')
                    
                    ->script("openDeleteModal('/admin/artikel/{$artikel->artikel_id}', '" . addslashes($artikel->judul) . "');");
            
            $browser->pause(500)
                    ->waitFor('#deleteConfirmModal', 5)
                    ->assertVisible('#deleteConfirmModal')
                    
                    ->with('#deleteConfirmModal', function ($modal) {
                        $modal->press('Hapus');
                    })
                    
                    ->pause(1500)
                    ->assertPathIs('/admin/artikel')
                    ->assertSee('Artikel berhasil dihapus.');
        });
    }
}
