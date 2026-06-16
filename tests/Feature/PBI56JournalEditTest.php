<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Journal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PBI56JournalEditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
    }

    /**
     * Pengguna dapat mengedit catatan jurnal miliknya sendiri.
     */
    public function test_user_can_edit_their_own_journal(): void
    {
        $user = User::factory()->create();
        $journal = Journal::create([
            'user_id' => $user->id,
            'content' => 'Teks awal sebelum diedit',
        ]);

        // Mengirimkan request edit jurnal
        $response = $this->actingAs($user)->put("/journals/{$journal->journal_id}", [
            'content' => 'Teks baru setelah diedit',
        ]);

        $response->assertRedirect(route('journals.index'));
        
        // Cek database diperbarui
        $this->assertDatabaseHas('journals', [
            'journal_id' => $journal->journal_id,
            'content' => 'Teks baru setelah diedit',
        ]);
    }

    /**
     * Pengguna dilarang mengedit catatan jurnal milik pengguna lain.
     */
    public function test_user_cannot_edit_other_users_journal(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        
        $journalB = Journal::create([
            'user_id' => $userB->id,
            'content' => 'Jurnal rahasia milik User B',
        ]);

        // User A mencoba mengakses halaman edit jurnal milik User B
        $responseGet = $this->actingAs($userA)->get("/journals/{$journalB->journal_id}/edit");
        $responseGet->assertStatus(403);

        // User A mencoba melakukan update jurnal milik User B
        $responsePut = $this->actingAs($userA)->put("/journals/{$journalB->journal_id}", [
            'content' => 'Upaya hack isi jurnal',
        ]);
        $responsePut->assertStatus(403);

        // Isi jurnal di database harus tetap tidak berubah
        $this->assertDatabaseHas('journals', [
            'journal_id' => $journalB->journal_id,
            'content' => 'Jurnal rahasia milik User B',
        ]);
    }

    /**
     * Validasi: Pengguna tidak boleh mengedit jurnal menjadi kosong.
     */
    public function test_user_cannot_update_journal_with_empty_content(): void
    {
        $user = User::factory()->create();
        $journal = Journal::create([
            'user_id' => $user->id,
            'content' => 'Jurnal valid',
        ]);

        $response = $this->actingAs($user)->put("/journals/{$journal->journal_id}", [
            'content' => '', // Kosong
        ]);

        $response->assertSessionHasErrors(['content']);
        
        // Isi jurnal di database harus tetap tidak berubah
        $this->assertEquals('Jurnal valid', $journal->fresh()->content);
    }
}
