<?php

namespace Tests\Feature;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CounselingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * PBI 27: Filter pencarian konselor berdasarkan kategori spesialisasi
     */
    public function test_pbi_27_menampilkan_konselor_berdasarkan_spesialisasi_yang_dipilih()
    {
        $user = User::factory()->create();
        $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
        $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Konseling Akademik']);
        $konselor3 = ProfilKonselor::factory()->create(['spesialisasi' => 'Karir']);

        $response = $this->actingAs($user)->get('/konseling?spesialisasi=Kesehatan Mental');

        $response->assertStatus(200);
        $response->assertSee($konselor1->nama);
        $response->assertDontSee($konselor2->nama);
        $response->assertDontSee($konselor3->nama);
    }

    /**
     * PBI 64: Search konselor berdasarkan nama, keahlian, atau gejala
     */
    public function test_pbi_64_mencari_konselor_berdasarkan_keyword_search()
    {
        $user = User::factory()->create();
        $konselor1 = ProfilKonselor::factory()->create(['nama' => 'Riana Ar-Zahra, M.Psi.', 'keahlian' => 'Terapi Kognitif', 'gejala' => 'Depresi']);
        $konselor2 = ProfilKonselor::factory()->create(['nama' => 'Budi Rahardjo, S.Psi.', 'keahlian' => 'Konseling Akademik', 'gejala' => 'Stres']);

        $response = $this->actingAs($user)->get('/konseling?search=Depresi');

        $response->assertStatus(200);
        $response->assertSee($konselor1->nama);
        $response->assertDontSee($konselor2->nama);
    }

    /**
     * PBI 64: Filter konselor berdasarkan ketersediaan sesi
     */
    public function test_pbi_64_filter_konselor_tersedia_hanya_menampilkan_konselor_dengan_sesi_tersedia()
    {
        $user = User::factory()->create();
        $konselor1 = ProfilKonselor::factory()->create(['spesialisasi' => 'Kesehatan Mental']);
        $konselor2 = ProfilKonselor::factory()->create(['spesialisasi' => 'Karir']);

        SesiKonseling::factory()->create([
            'profil_konselor_id' => $konselor1->profil_konselor_id,
            'status' => 'pending'
        ]);

        SesiKonseling::factory()->create([
            'profil_konselor_id' => $konselor2->profil_konselor_id,
            'status' => 'penuh'
        ]);

        $response = $this->actingAs($user)->get('/konseling?ketersediaan=tersedia');

        $response->assertStatus(200);
        $response->assertSee($konselor1->nama);
        $response->assertDontSee($konselor2->nama);
    }

    /**
     * PBI 28: Halaman profil detail konselor (biografi & keahlian)
     */
    public function test_pbi_28_menampilkan_profil_detail_konselor_dengan_biografi_dan_keahlian()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create([
            'biografi' => 'Konselor profesional berpengalaman',
            'keahlian' => 'Terapi Kognitif Perilaku'
        ]);

        $response = $this->actingAs($user)->get(route('konseling.show', $konselor->profil_konselor_id));

        $response->assertStatus(200);
        $response->assertSee($konselor->nama);
        $response->assertSee($konselor->biografi);
        $response->assertSee($konselor->keahlian);
    }

    /**
     * PBI 29: Logika dan alur pemesanan konselor
     */
    public function test_pbi_29_menyimpan_data_pemesanan_sesi_konseling_ke_database()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $jadwal = Carbon::now()->addDays(2)->toDateTimeString();

        $response = $this->actingAs($user)->post(route('booking.store'), [
            'konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => $jadwal,
            'deskripsi' => 'Diskusi topik stres akademik',
            'media_konseling' => 'video_call',
            'payment_method' => 'transfer',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => $jadwal,
            'status' => 'pending'
        ]);
    }

    /**
     * PBI 35: Pembayaran sesi konseling dicatat dengan metode dan status yang benar
     */
    public function test_pbi_35_menyimpan_metode_dan_status_pembayaran_saat_membooking_sesi()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create(['harga_per_sesi' => 150000]);
        $jadwal = Carbon::now()->addDays(2)->toDateTimeString();

        $response = $this->actingAs($user)->post(route('booking.store'), [
            'konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => $jadwal,
            'deskripsi' => 'Diskusi topik stres akademik',
            'media_konseling' => 'video_call',
            'payment_method' => 'transfer',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'payment_method' => 'transfer',
            'payment_status' => 'pending',
            'status' => 'pending'
        ]);
    }

    /**
     * PBI 35: Pembayaran dikembalikan ketika sesi pending kedaluwarsa
     */
    public function test_pbi_35_payment_status_refunded_when_pending_session_expires()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'user_id' => $user->id,
            'status' => 'pending',
            'payment_status' => 'paid',
            'created_at' => Carbon::now()->subMinutes(5),
        ]);

        $response = $this->actingAs($user)->post(route('booking.checkExpired'));

        $response->assertStatus(200);
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'status' => 'system_cancelled',
            'payment_status' => 'refunded',
        ]);
    }

    /**
     * PBI 30: Sistem notifikasi reservasi
     */
    public function test_pbi_30_menampilkan_notifikasi_sukses_setelah_reservasi()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $jadwal = Carbon::now()->addDays(2)->toDateTimeString();

        $response = $this->actingAs($user)->post(route('booking.store'), [
            'konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => $jadwal,
            'deskripsi' => 'Diskusi topik stres akademik',
            'media_konseling' => 'video_call',
            'payment_method' => 'transfer',
        ]);

        $response->assertSessionHas('success');
    }

    /**
     * PBI 30: Sistem notifikasi perubahan jadwal
     */
    public function test_pbi_30_menampilkan_notifikasi_info_setelah_perubahan_jadwal()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => Carbon::now()->addDays(2)->toDateTimeString(),
            'status' => 'pending'
        ]);

        $response = $this->actingAs($user)->put(route('booking.update', $sesi->sesi_konseling_id), [
            'jadwal' => Carbon::now()->addDays(3)->toDateTimeString()
        ]);

        $response->assertSessionHas('success');
    }

    /**
     * PBI 30: Sistem notifikasi pembatalan
     */
    public function test_pbi_30_menampilkan_notifikasi_error_setelah_pembatalan()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($user)->delete(route('booking.cancel', $sesi->sesi_konseling_id));

        $response->assertSessionHas('success');
    }

    /**
     * PBI 31: Alur pengajuan perubahan jadwal sesi
     */
    public function test_pbi_31_memperbarui_jadwal_sesi_konseling_di_database()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => Carbon::now()->addDays(2)->toDateTimeString(),
            'status' => 'pending'
        ]);

        $jadwalBaru = Carbon::now()->addDays(3)->toDateTimeString();

        $response = $this->actingAs($user)->put(route('booking.update', $sesi->sesi_konseling_id), [
            'jadwal' => $jadwalBaru
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'requested_jadwal' => $jadwalBaru,
            'status' => 'change_requested'
        ]);
    }

    /**
     * PBI 31 (Tambahan): Membatalkan sesi konseling
     */
    public function test_pbi_31_membatalkan_sesi_konseling_dengan_status_cancelled()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($user)->delete(route('booking.cancel', $sesi->sesi_konseling_id));

        $response->assertRedirect();
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'status' => 'cancelled'
        ]);
    }

    public function test_confirmed_session_cannot_be_cancelled_by_user()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'confirmed'
        ]);

        $response = $this->actingAs($user)->delete(route('booking.cancel', $sesi->sesi_konseling_id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Sesi yang sudah disetujui oleh konselor tidak dapat dibatalkan.');
        
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'status' => 'confirmed'
        ]);
    }

    public function test_paid_pending_session_cancellation_triggers_refund()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'status' => 'pending',
            'payment_status' => 'paid'
        ]);

        $response = $this->actingAs($user)->delete(route('booking.cancel', $sesi->sesi_konseling_id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Jadwal konsultasi berhasil dibatalkan dan pembayaran Anda akan dikembalikan (Refunded).');
        
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'status' => 'cancelled',
            'payment_status' => 'refunded'
        ]);
    }


    /**
     * PBI 45: Pembatalan otomatis sesi yang kadaluarsa
     */
    public function test_pbi_45_pembatalan_otomatis_sesi_kadaluarsa()
    {
        $user = User::factory()->create();
        $konselor = ProfilKonselor::factory()->create();
        
        // Membuat sesi pending di masa lampau (kadaluarsa)
        $sesi = SesiKonseling::factory()->create([
            'user_id' => $user->id,
            'profil_konselor_id' => $konselor->profil_konselor_id,
            'jadwal' => now()->subDay(), // Kemarin
            'status' => 'pending'
        ]);

        // Akses halaman home
        $response = $this->actingAs($user)->get('/home');

        // Sesi harusnya berubah menjadi cancelled
        $this->assertDatabaseHas('sesi_konselings', [
            'sesi_konseling_id' => $sesi->sesi_konseling_id,
            'status' => 'cancelled'
        ]);

        // Dan session harus memiliki data expired_cancelled_sessions
        $response->assertSessionHas('expired_cancelled_sessions');
    }
}
