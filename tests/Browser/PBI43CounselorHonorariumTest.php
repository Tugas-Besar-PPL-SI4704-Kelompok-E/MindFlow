<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PBI43CounselorHonorariumTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
    }

    


    public function test_admin_can_access_transactions_and_honorarium_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/transaksi');

        $response->assertStatus(200);
        $response->assertSee('Kelola Transaksi');
    }

    


    public function test_regular_user_and_counselor_cannot_access_transactions_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $counselor = User::factory()->create(['role' => 'konselor', 'status' => 'approved']);

        
        $responseUser = $this->actingAs($user)->get('/admin/transaksi');
        $responseUser->assertStatus(403);

        
        $responseCounselor = $this->actingAs($counselor)->get('/admin/transaksi');
        $responseCounselor->assertStatus(403);
    }

    


    public function test_honorarium_is_recorded_automatically_when_session_completed(): void
    {
        $counselorUser = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved',
        ]);
        
        $profil = ProfilKonselor::factory()->create([
            'user_id' => $counselorUser->id,
            'harga_per_sesi' => 150000,
            'saldo' => 0,
        ]);

        $sesi = SesiKonseling::factory()->create([
            'profil_konselor_id' => $profil->profil_konselor_id,
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        
        $response = $this->actingAs($counselorUser)->post(route('konselor.jadwal.evaluasi', $sesi->sesi_konseling_id), [
            'catatan_konselor' => 'Sesi berjalan lancar, pasien menunjukkan perbaikan.',
        ]);

        $response->assertRedirect();
        
        
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'status' => 'completed',
        ]);

        
        $this->assertDatabaseHas('transactions', [
            'profil_konselor_id' => $profil->profil_konselor_id,
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'amount' => 150000,
            'type' => 'deposit',
            'status' => 'approved',
        ]);

        
        $this->assertEquals(150000, $profil->fresh()->saldo);
    }
}
