<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;

class AdminKonselingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_confirm_session()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $profil = ProfilKonselor::factory()->create(['user_id' => $admin->id]);

        $sesi = SesiKonseling::create([
            'user_id' => $user->id,
            'profil_konselor_id' => $profil->profil_konselor_id,
            'jadwal' => now()->addDays(1),
            'media_konseling' => 'chat',
            'deskripsi' => 'test',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.konseling.confirm', $sesi->sesi_konseling_id ?? $sesi->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('sesi_konselings', ['sesi_konseling_id' => $sesi->sesi_konseling_id ?? $sesi->id, 'status' => 'confirmed']);
    }

    public function test_admin_can_cancel_session()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $profil = ProfilKonselor::factory()->create(['user_id' => $admin->id]);

        $sesi = SesiKonseling::create([
            'user_id' => $user->id,
            'profil_konselor_id' => $profil->profil_konselor_id,
            'jadwal' => now()->addDays(1),
            'media_konseling' => 'chat',
            'deskripsi' => 'test',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.konseling.cancel', $sesi->sesi_konseling_id ?? $sesi->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('sesi_konselings', ['sesi_konseling_id' => $sesi->sesi_konseling_id ?? $sesi->id, 'status' => 'cancelled']);
    }
}
