<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Faq;

class AdminFaqTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guest_can_view_public_faq_page()
    {
        
        $faq = Faq::create([
            'question' => 'Bagaimana cara mendaftar?',
            'answer' => 'Anda bisa menekan tombol Sign Up.'
        ]);

        $response = $this->get(route('faq'));
        $response->assertStatus(200);
        $response->assertSee('Bagaimana cara mendaftar?');
        $response->assertSee('Anda bisa menekan tombol Sign Up.');
    }

    public function test_admin_can_view_faq_management_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $faq = Faq::create([
            'question' => 'Pertanyaan Admin',
            'answer' => 'Jawaban Admin'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faq'));
        $response->assertStatus(200);
        $response->assertSee('Pertanyaan Admin');
    }

    public function test_admin_can_create_faq()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.faq.store'), [
            'question' => 'Pertanyaan Baru',
            'answer' => 'Jawaban Baru'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('faqs', [
            'question' => 'Pertanyaan Baru',
            'answer' => 'Jawaban Baru'
        ]);
    }

    public function test_admin_can_update_faq()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $faq = Faq::create([
            'question' => 'Pertanyaan Lama',
            'answer' => 'Jawaban Lama'
        ]);

        $response = $this->actingAs($admin)->put(route('admin.faq.update', $faq->id), [
            'question' => 'Pertanyaan Diubah',
            'answer' => 'Jawaban Diubah'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'Pertanyaan Diubah',
            'answer' => 'Jawaban Diubah'
        ]);
    }

    public function test_admin_can_delete_faq()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $faq = Faq::create([
            'question' => 'Pertanyaan Hapus',
            'answer' => 'Jawaban Hapus'
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.faq.destroy', $faq->id));
        $response->assertRedirect();
        $this->assertDatabaseMissing('faqs', [
            'id' => $faq->id
        ]);
    }

    public function test_logged_in_user_can_view_faq_in_settings()
    {
        $user = User::factory()->create(['role' => 'user']);
        $faq = Faq::create([
            'question' => 'Pertanyaan Settings',
            'answer' => 'Jawaban Settings'
        ]);

        $response = $this->actingAs($user)->get(route('settings.edit'));
        $response->assertStatus(200);
        $response->assertSee('Pertanyaan Settings');
        $response->assertSee('Jawaban Settings');
    }
}
