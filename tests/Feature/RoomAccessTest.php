<?php

namespace Tests\Feature;

use App\Models\SesiKonseling;
use App\Models\User;
use App\Models\ProfilKonselor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Set waktu sekarang ke tanggal tertentu untuk testing
        Carbon::setTestNow(Carbon::parse('2026-06-13 10:00:00'));
    }

    /** @test */
    public function cannot_enter_room_if_status_is_pending()
    {
        $sesi = SesiKonseling::factory()->create([
            'status' => 'pending',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
        ]);

        $this->assertFalse($sesi->canEnterRoom());
        $this->assertStringContainsString('belum dikonfirmasi', $sesi->getRoomAccessMessage());
    }

    /** @test */
    public function cannot_enter_room_if_payment_not_paid()
    {
        $sesi = SesiKonseling::factory()->create([
            'status' => 'confirmed',
            'payment_status' => 'pending',
            'jadwal' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
        ]);

        $this->assertFalse($sesi->canEnterRoom());
        $this->assertStringContainsString('Pembayaran belum selesai', $sesi->getRoomAccessMessage());
    }

    /** @test */
    public function cannot_enter_room_if_not_within_15_minutes_window()
    {
        $sesi = SesiKonseling::factory()->create([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addHours(2)->format('Y-m-d H:i:s')
        ]);

        $this->assertFalse($sesi->canEnterRoom());
        $this->assertStringContainsString('15 menit sebelum', $sesi->getRoomAccessMessage());
    }

    /** @test */
    public function can_enter_room_if_all_conditions_met()
    {
        $sesi = SesiKonseling::factory()->create([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
        ]);

        $this->assertTrue($sesi->canEnterRoom());
    }

    /** @test */
    public function can_enter_room_exactly_15_minutes_before()
    {
        $sesi = SesiKonseling::factory()->create([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addMinutes(15)->format('Y-m-d H:i:s')
        ]);

        $this->assertTrue($sesi->canEnterRoom());
    }

    /** @test */
    public function cannot_enter_room_1_second_before_15_minutes()
    {
        $sesi = SesiKonseling::factory()->create([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addMinutes(15)->addSecond()->format('Y-m-d H:i:s')
        ]);

        $this->assertFalse($sesi->canEnterRoom());
    }

    /** @test */
    public function can_enter_room_with_rescheduled_status()
    {
        $sesi = SesiKonseling::factory()->create([
            'status' => 'rescheduled',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
        ]);

        $this->assertTrue($sesi->canEnterRoom());
    }

    /** @test */
    public function patient_cannot_enter_room_without_payment()
    {
        $user = User::factory()->create(['role' => 'user']);
        $konselor = ProfilKonselor::factory()->create();

        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'confirmed',
            'payment_status' => 'pending',
            'jadwal' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
        ]);

        $response = $this->actingAs($user)->get(route('konseling.room', $sesi->sesi_konseling_id));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function patient_can_enter_room_with_valid_conditions()
    {
        $user = User::factory()->create(['role' => 'user']);
        $konselor = ProfilKonselor::factory()->create();

        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
        ]);

        $response = $this->actingAs($user)->get(route('konseling.room', $sesi->sesi_konseling_id));
        $response->assertSuccessful();
        $response->assertViewIs('konseling.room');
    }

    /** @test */
    public function counselor_cannot_accept_unpaid_session()
    {
        $user = User::factory()->create(['role' => 'user']);
        $konselor = ProfilKonselor::factory()->create();
        $konselorUser = $konselor->user;

        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'jadwal' => Carbon::now()->addHours(2)->format('Y-m-d H:i:s')
        ]);

        $response = $this->actingAs($konselorUser)->post(route('konselor.jadwal.accept', $sesi->sesi_konseling_id));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        $sesi->refresh();
        $this->assertNotEquals('confirmed', $sesi->status);
    }

    /** @test */
    public function counselor_can_accept_paid_session()
    {
        $user = User::factory()->create(['role' => 'user']);
        $konselor = ProfilKonselor::factory()->create();
        $konselorUser = $konselor->user;

        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'pending',
            'payment_status' => 'paid',
            'jadwal' => Carbon::now()->addHours(2)->format('Y-m-d H:i:s')
        ]);

        $response = $this->actingAs($konselorUser)->post(route('konselor.jadwal.accept', $sesi->sesi_konseling_id));
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $sesi->refresh();
        $this->assertEquals('confirmed', $sesi->status);
    }
}
