<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Artikel;
use App\Models\ArtikelReport;

class ArtikelReportTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;
    protected $artikel;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
        
        
        $this->artikel = Artikel::create([
            'admin_id' => $this->admin->id,
            'judul' => 'Judul Artikel Test',
            'konten' => 'Konten artikel test yang sangat panjang.',
            'status' => 'published',
            'kategori' => 'Kesehatan Mental'
        ]);
    }

    public function test_user_can_report_article()
    {
        $response = $this->actingAs($this->user)
            ->post(route('artikel.report', $this->artikel->artikel_id), [
                'reason' => 'Informasi salah dan menyesatkan'
            ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('artikel_reports', [
            'artikel_id' => $this->artikel->artikel_id,
            'user_id' => $this->user->id,
            'reason' => 'Informasi salah dan menyesatkan',
            'status' => 'pending'
        ]);
    }

    public function test_admin_cannot_report_article()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('artikel.report', $this->artikel->artikel_id), [
                'reason' => 'Spam'
            ]);

        $response->assertStatus(403);
        $this->assertDatabaseCount('artikel_reports', 0);
    }

    public function test_admin_can_view_reports_list()
    {
        
        ArtikelReport::create([
            'artikel_id' => $this->artikel->artikel_id,
            'user_id' => $this->user->id,
            'reason' => 'Konten tidak pantas'
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.laporan'));

        $response->assertStatus(200);
        $response->assertSee('Konten tidak pantas');
        $response->assertSee('Judul Artikel Test');
    }

    public function test_admin_can_dismiss_report()
    {
        $report = ArtikelReport::create([
            'artikel_id' => $this->artikel->artikel_id,
            'user_id' => $this->user->id,
            'reason' => 'Konten tidak pantas'
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.laporan.artikel.delete', $report->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('artikel_reports', ['id' => $report->id]);
    }

    public function test_admin_can_delete_reported_article()
    {
        $report = ArtikelReport::create([
            'artikel_id' => $this->artikel->artikel_id,
            'user_id' => $this->user->id,
            'reason' => 'Konten tidak pantas'
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.artikel.delete', $this->artikel->artikel_id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('artikels', ['artikel_id' => $this->artikel->artikel_id]);
        $this->assertDatabaseMissing('artikel_reports', ['id' => $report->id]); 
    }
}
