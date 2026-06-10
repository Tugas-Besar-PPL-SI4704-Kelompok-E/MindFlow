<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class AdminArtikelCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
    }

    public function test_unauthorized_guests_are_redirected()
    {
        $this->get(route('admin.artikel.index'))->assertRedirect(route('login'));
        $this->get(route('admin.artikel.create'))->assertRedirect(route('login'));
        $this->post(route('admin.artikel.store'), [])->assertRedirect(route('login'));
        $this->get(route('admin.artikel.edit', 1))->assertRedirect(route('login'));
        $this->put(route('admin.artikel.update', 1), [])->assertRedirect(route('login'));
        $this->delete(route('admin.artikel.destroy', 1))->assertRedirect(route('login'));
    }

    public function test_non_admin_users_cannot_access_crud()
    {
        $this->actingAs($this->user)->get(route('admin.artikel.index'))->assertStatus(403);
        $this->actingAs($this->user)->get(route('admin.artikel.create'))->assertStatus(403);
        $this->actingAs($this->user)->post(route('admin.artikel.store'), [])->assertStatus(403);
        $this->actingAs($this->user)->get(route('admin.artikel.edit', 1))->assertStatus(403);
        $this->actingAs($this->user)->put(route('admin.artikel.update', 1), [])->assertStatus(403);
        $this->actingAs($this->user)->delete(route('admin.artikel.destroy', 1))->assertStatus(403);
    }

    public function test_admin_can_view_articles_index_with_filtering_and_searching()
    {
        $artikel1 = Artikel::create([
            'admin_id' => $this->admin->id,
            'judul' => 'Stres Akademik',
            'konten' => 'Mengatasi stres di bangku kuliah.',
            'kategori' => 'Edukasi',
            'penerbit' => 'MindFlow Team',
            'status' => 'published',
        ]);

        $artikel2 = Artikel::create([
            'admin_id' => $this->admin->id,
            'judul' => 'Tips Meditasi Pagi',
            'konten' => 'Langkah meditasi 10 menit.',
            'kategori' => 'Tips & Trik',
            'penerbit' => 'MindFlow Team',
            'status' => 'draft',
        ]);

        // Access index as admin
        $response = $this->actingAs($this->admin)->get(route('admin.artikel.index'));
        $response->assertStatus(200);
        $response->assertSee('Stres Akademik');
        $response->assertSee('Tips Meditasi Pagi');

        // Search check
        $responseSearch = $this->actingAs($this->admin)->get(route('admin.artikel.index', ['search' => 'Stres']));
        $responseSearch->assertSee('Stres Akademik');
        $responseSearch->assertDontSee('Tips Meditasi Pagi');

        // Category filter check
        $responseCategory = $this->actingAs($this->admin)->get(route('admin.artikel.index', ['kategori' => 'Tips & Trik']));
        $responseCategory->assertSee('Tips Meditasi Pagi');
        $responseCategory->assertDontSee('Stres Akademik');

        // Status filter check
        $responseStatus = $this->actingAs($this->admin)->get(route('admin.artikel.index', ['status' => 'draft']));
        $responseStatus->assertSee('Tips Meditasi Pagi');
        $responseStatus->assertDontSee('Stres Akademik');
    }

    public function test_admin_can_store_article_with_default_penerbit()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.artikel.store'), [
            'judul' => 'Judul Artikel Baru',
            'konten' => 'Ini konten artikel yang baru saja di buat.',
            'kategori' => 'Edukasi',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.artikel.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('artikels', [
            'judul' => 'Judul Artikel Baru',
            'konten' => 'Ini konten artikel yang baru saja di buat.',
            'kategori' => 'Edukasi',
            'penerbit' => $this->admin->nama_asli,
            'status' => 'published',
        ]);
    }

    public function test_admin_can_store_article_with_custom_metadata_and_cover_image()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('cover_dummy.jpg', 100, 'image/jpeg');

        $customDate = Carbon::parse('2026-06-01 12:00:00');

        $response = $this->actingAs($this->admin)->post(route('admin.artikel.store'), [
            'judul' => 'Artikel Kustom Lengkap',
            'konten' => 'Isi konten lengkap.',
            'kategori' => '',
            'kategori_baru' => 'Kategori Baru Kreatif',
            'penerbit' => 'Penerbit Independen',
            'status' => 'draft',
            'gambar_cover' => $file,
            'created_at' => '2026-06-01 12:00:00',
        ]);

        $response->assertRedirect(route('admin.artikel.index'));

        // Retrieve the stored article to check the cover image path
        $artikel = Artikel::where('judul', 'Artikel Kustom Lengkap')->firstOrFail();
        
        $this->assertNotNull($artikel->gambar_cover);
        Storage::disk('public')->assertExists($artikel->gambar_cover);

        $this->assertEquals('Kategori Baru Kreatif', $artikel->kategori);
        $this->assertEquals('Penerbit Independen', $artikel->penerbit);
        $this->assertEquals('draft', $artikel->status);
        $this->assertEquals($customDate->format('Y-m-d H:i:s'), $artikel->created_at->format('Y-m-d H:i:s'));
    }

    public function test_admin_can_update_article_and_replace_image()
    {
        Storage::fake('public');
        $oldFile = UploadedFile::fake()->create('old_cover.jpg', 100, 'image/jpeg');
        $newFile = UploadedFile::fake()->create('new_cover.png', 100, 'image/png');

        // Create initial article
        $artikel = Artikel::create([
            'admin_id' => $this->admin->id,
            'judul' => 'Artikel Edit',
            'konten' => 'Isi artikel edit.',
            'kategori' => 'Edukasi',
            'penerbit' => 'Penerbit Asli',
            'status' => 'draft',
            'gambar_cover' => $oldFile->store('artikel/cover', 'public'),
        ]);

        Storage::disk('public')->assertExists($artikel->gambar_cover);
        $oldPath = $artikel->gambar_cover;

        // Perform edit
        $response = $this->actingAs($this->admin)->put(route('admin.artikel.update', $artikel->artikel_id), [
            'judul' => 'Artikel Berhasil Diedit',
            'konten' => 'Konten setelah diedit.',
            'kategori' => 'Motivasi',
            'penerbit' => 'Penerbit Edit',
            'status' => 'published',
            'gambar_cover' => $newFile,
            'created_at' => '2026-06-05 15:30:00',
        ]);

        $response->assertRedirect(route('admin.artikel.index'));
        $response->assertSessionHas('success');

        $artikel->refresh();

        $this->assertEquals('Artikel Berhasil Diedit', $artikel->judul);
        $this->assertEquals('Konten setelah diedit.', $artikel->konten);
        $this->assertEquals('Motivasi', $artikel->kategori);
        $this->assertEquals('Penerbit Edit', $artikel->penerbit);
        $this->assertEquals('published', $artikel->status);
        $this->assertEquals(Carbon::parse('2026-06-05 15:30:00')->format('Y-m-d H:i:s'), $artikel->created_at->format('Y-m-d H:i:s'));

        // Check file storage: old cover is deleted, new cover exists
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($artikel->gambar_cover);
    }

    public function test_admin_can_delete_article()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('cover_del.jpg', 100, 'image/jpeg');

        $artikel = Artikel::create([
            'admin_id' => $this->admin->id,
            'judul' => 'Artikel Untuk Dihapus',
            'konten' => 'Konten hapus.',
            'kategori' => 'Edukasi',
            'penerbit' => 'Penerbit',
            'status' => 'published',
            'gambar_cover' => $file->store('artikel/cover', 'public'),
        ]);

        $coverPath = $artikel->gambar_cover;
        Storage::disk('public')->assertExists($coverPath);

        $response = $this->actingAs($this->admin)->delete(route('admin.artikel.destroy', $artikel->artikel_id));
        $response->assertRedirect(route('admin.artikel.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('artikels', [
            'artikel_id' => $artikel->artikel_id,
        ]);

        // Check cover image deleted
        Storage::disk('public')->assertMissing($coverPath);
    }

    public function test_admin_can_view_draft_and_published_article_detail()
    {
        $publishedArtikel = Artikel::create([
            'admin_id' => $this->admin->id,
            'judul' => 'Published Article',
            'konten' => 'This is published.',
            'status' => 'published',
            'kategori' => 'Edukasi'
        ]);

        $draftArtikel = Artikel::create([
            'admin_id' => $this->admin->id,
            'judul' => 'Draft Article',
            'konten' => 'This is draft.',
            'status' => 'draft',
            'kategori' => 'Motivasi'
        ]);

        // Admin can view published
        $response = $this->actingAs($this->admin)->get(route('artikel.show', $publishedArtikel->artikel_id));
        $response->assertStatus(200);
        $response->assertSee('Published Article');

        // Admin can view draft
        $response = $this->actingAs($this->admin)->get(route('artikel.show', $draftArtikel->artikel_id));
        $response->assertStatus(200);
        $response->assertSee('Draft Article');

        // Regular user can view published
        $response = $this->actingAs($this->user)->get(route('artikel.show', $publishedArtikel->artikel_id));
        $response->assertStatus(200);
        $response->assertSee('Published Article');

        // Regular user cannot view draft
        $response = $this->actingAs($this->user)->get(route('artikel.show', $draftArtikel->artikel_id));
        $response->assertStatus(404);
    }
}
