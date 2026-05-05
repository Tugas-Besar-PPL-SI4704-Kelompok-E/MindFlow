<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Journal;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class JournalTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_a_journal()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/journals')
                    ->clickLink('Ketuk untuk menulis jurnal')
                    ->pause(1000)
                    ->assertPathIs('/journals/create')
                    ->type('content', 'Hari ini saya merasa sangat senang karena fitur jurnal selesai dibuat.')
                    ->press('Simpan Jurnal') 
                    ->pause(1000)
                    ->assertPathIs('/journals')
                    ->assertSee('Hari ini saya merasa sangat senang karena fitur jurnal selesai dibuat.');
        });
    }

    public function test_user_cannot_create_empty_journal()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/journals/create')
                    ->pause(500)
                    ->type('content', '')
                    ->press('Simpan Jurnal')
                    ->pause(500)
                    ->assertPathIs('/journals/create'); 
        });
    }

    public function test_user_can_edit_a_journal()
    {
        $user = User::factory()->create();
        $journal = Journal::create([
            'user_id' => $user->id,
            'content' => 'Teks awal jurnal sebelum diubah',
        ]);

        $this->browse(function (Browser $browser) use ($user, $journal) {
            $browser->loginAs($user)
                    ->visit('/journals')
                    ->pause(500)
                    ->clickLink('Edit')
                    ->pause(1000)
                    ->assertPathIs("/journals/{$journal->journal_id}/edit")
                    ->clear('content')
                    ->type('content', 'Teks jurnal sudah berhasil diedit')
                    ->press('Simpan Perubahan')
                    ->pause(1000)
                    ->assertPathIs('/journals')
                    ->assertSee('Teks jurnal sudah berhasil diedit')
                    ->assertSee('(Diedit)');
        });
    }

    public function test_user_can_delete_a_journal()
    {
        $user = User::factory()->create();
        $journal = Journal::create([
            'user_id' => $user->id,
            'content' => 'Jurnal sementara untuk dihapus',
        ]);

        $this->browse(function (Browser $browser) use ($user, $journal) {
            $browser->loginAs($user)
                    ->visit('/journals')
                    ->pause(500)
                    ->assertSee('Jurnal sementara untuk dihapus')
                    ->press('Hapus') 
                    ->pause(500)
                    ->acceptDialog()
                    ->pause(1000)
                    ->assertPathIs('/journals')
                    ->assertDontSee('Jurnal sementara untuk dihapus');
        });
    }

    public function test_user_can_save_stress_trigger_story()
    {
        $user = User::factory()->create();
        $longText = 'Hari ini saya sangat stres karena revisi yang menumpuk. Kejadian ini dipicu oleh deadline yang sangat mepet. Saya harap ini segera selesai.';
        
        $this->browse(function (Browser $browser) use ($user, $longText) {
            $browser->loginAs($user)
                    ->visit('/journals/create')
                    ->pause(500)
                    ->type('content', $longText)
                    ->press('Simpan Jurnal')
                    ->pause(1000)
                    ->assertPathIs('/journals')
                    ->assertSee('Hari ini saya sangat stres karena revisi yang menumpuk'); 
        });
    }

    public function test_user_can_navigate_to_history_page()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/journals')
                    ->pause(500)
                    ->clickLink('Lihat History Lengkap')
                    ->pause(1000)
                    ->assertPathIs('/history');
        });
    }
}
