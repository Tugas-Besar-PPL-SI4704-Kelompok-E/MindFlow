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

    


    public function test_user_can_edit_their_own_journal(): void
    {
        $user = User::factory()->create();
        $journal = Journal::create([
            'user_id' => $user->id,
            'content' => 'Teks awal sebelum diedit',
        ]);

        
        $response = $this->actingAs($user)->put("/journals/{$journal->journal_id}", [
            'content' => 'Teks baru setelah diedit',
        ]);

        $response->assertRedirect(route('journals.index'));
        
        
        $this->assertDatabaseHas('journals', [
            'journal_id' => $journal->journal_id,
            'content' => 'Teks baru setelah diedit',
        ]);
    }

    


    public function test_user_cannot_edit_other_users_journal(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        
        $journalB = Journal::create([
            'user_id' => $userB->id,
            'content' => 'Jurnal rahasia milik User B',
        ]);

        
        $responseGet = $this->actingAs($userA)->get("/journals/{$journalB->journal_id}/edit");
        $responseGet->assertStatus(403);

        
        $responsePut = $this->actingAs($userA)->put("/journals/{$journalB->journal_id}", [
            'content' => 'Upaya hack isi jurnal',
        ]);
        $responsePut->assertStatus(403);

        
        $this->assertDatabaseHas('journals', [
            'journal_id' => $journalB->journal_id,
            'content' => 'Jurnal rahasia milik User B',
        ]);
    }

    


    public function test_user_cannot_update_journal_with_empty_content(): void
    {
        $user = User::factory()->create();
        $journal = Journal::create([
            'user_id' => $user->id,
            'content' => 'Jurnal valid',
        ]);

        $response = $this->actingAs($user)->put("/journals/{$journal->journal_id}", [
            'content' => '', 
        ]);

        $response->assertSessionHasErrors(['content']);
        
        
        $this->assertEquals('Jurnal valid', $journal->fresh()->content);
    }
}
