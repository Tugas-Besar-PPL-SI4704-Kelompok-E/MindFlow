<?php

namespace Tests\Feature;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFinanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_user_can_view_checkout_page()
    {
        $user = User::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('booking.checkout', $sesi->sesi_konseling_id));

        $response->assertStatus(200);
        $response->assertSee('Checkout');
        $response->assertSee($sesi->profilKonselor->nama);
    }

    public function test_user_can_pay_via_ewallet_immediately_marks_paid()
    {
        $user = User::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'payment_method' => 'e-wallet',
            'payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post(route('booking.pay', $sesi->sesi_konseling_id));

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'payment_status' => 'paid',
        ]);
    }

    public function test_user_can_pay_via_bank_transfer_marks_waiting_verification()
    {
        $user = User::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'payment_method' => 'transfer',
            'payment_status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post(route('booking.pay', $sesi->sesi_konseling_id));

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'payment_status' => 'waiting_verification',
        ]);
    }

    public function test_admin_can_verify_bank_transfer_payment()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $sesi = SesiKonseling::factory()->create([
            'payment_status' => 'waiting_verification',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.transaksi.verify-payment', $sesi->sesi_konseling_id));

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'payment_status' => 'paid',
        ]);
    }

    public function test_counselor_earns_honorarium_upon_evaluasi_session_completed()
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

    public function test_counselor_can_request_withdrawal()
    {
        $counselorUser = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved',
        ]);
        $profil = ProfilKonselor::factory()->create([
            'user_id' => $counselorUser->id,
            'saldo' => 200000,
        ]);

        $response = $this->actingAs($counselorUser)->post(route('konselor.dompet.withdraw'), [
            'amount' => 50000,
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'John Doe',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'profil_konselor_id' => $profil->profil_konselor_id,
            'amount' => 50000,
            'type' => 'withdrawal',
            'status' => 'pending',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'John Doe',
        ]);

        $this->assertEquals(150000, $profil->fresh()->saldo);
    }

    public function test_admin_can_approve_withdrawal()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $counselorUser = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved',
        ]);
        $profil = ProfilKonselor::factory()->create([
            'user_id' => $counselorUser->id,
            'saldo' => 100000, // already decremented when requested
        ]);

        $tx = Transaction::create([
            'profil_konselor_id' => $profil->profil_konselor_id,
            'amount' => 50000,
            'type' => 'withdrawal',
            'status' => 'pending',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'John Doe',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.transaksi.approve-withdrawal', $tx->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'id' => $tx->id,
            'status' => 'approved',
        ]);

        $this->assertEquals(100000, $profil->fresh()->saldo);
    }

    public function test_admin_can_reject_withdrawal_and_refund_balance()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $counselorUser = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved',
        ]);
        $profil = ProfilKonselor::factory()->create([
            'user_id' => $counselorUser->id,
            'saldo' => 100000, // already decremented when requested
        ]);

        $tx = Transaction::create([
            'profil_konselor_id' => $profil->profil_konselor_id,
            'amount' => 50000,
            'type' => 'withdrawal',
            'status' => 'pending',
            'bank_name' => 'BCA',
            'account_number' => '1234567890',
            'account_holder' => 'John Doe',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.transaksi.reject-withdrawal', $tx->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('transactions', [
            'id' => $tx->id,
            'status' => 'rejected',
        ]);

        $this->assertEquals(150000, $profil->fresh()->saldo);
    }

    public function test_admin_verifies_payment_for_already_completed_session_credits_counselor()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $counselorUser = User::factory()->create([
            'role' => 'konselor',
            'status' => 'approved',
        ]);
        $profil = ProfilKonselor::factory()->create([
            'user_id' => $counselorUser->id,
            'harga_per_sesi' => 120000,
            'saldo' => 0,
        ]);

        $sesi = SesiKonseling::factory()->create([
            'profil_konselor_id' => $profil->profil_konselor_id,
            'payment_status' => 'waiting_verification',
            'status' => 'completed',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.transaksi.verify-payment', $sesi->sesi_konseling_id));

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'payment_status' => 'paid',
        ]);

        $this->assertDatabaseHas('transactions', [
            'profil_konselor_id' => $profil->profil_konselor_id,
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'amount' => 120000,
            'type' => 'deposit',
            'status' => 'approved',
        ]);

        $this->assertEquals(120000, $profil->fresh()->saldo);
    }
}
