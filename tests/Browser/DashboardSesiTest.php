<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\CounselorSchedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardSesiTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        // User yang sudah punya sesi konseling
        $user = User::firstOrCreate(
            ['email' => 'asep@example.com'],
            [
                'nama_asli'    => 'Asep',
                'nama_samaran' => 'Asep',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'status'       => 'approved',
            ]
        );

        // User baru tanpa riwayat apapun
        User::firstOrCreate(
            ['email' => 'akunbaru@example.com'],
            [
                'nama_asli'    => 'Akun Baru',
                'nama_samaran' => 'Akun Baru',
                'password'     => Hash::make('password'),
                'role'         => 'user',
                'status'       => 'approved',
            ]
        );

        // Buat konselor
        $konselorUser = User::firstOrCreate(
            ['email' => 'konselor@example.com'],
            [
                'nama_asli'    => 'Dr. Konselor',
                'nama_samaran' => 'Dr. Konselor',
                'password'     => Hash::make('password'),
                'role'         => 'konselor',
                'status'       => 'approved',
            ]
        );

        $profil = ProfilKonselor::firstOrCreate(
            ['user_id' => $konselorUser->id],
            [
                'nama'          => 'Dr. Konselor',
                'spesialisasi'  => 'Kecemasan',
                'biografi'      => 'Konselor berpengalaman.',
                'keahlian'      => 'CBT, Mindfulness',
                'harga_per_sesi'=> 100000,
            ]
        );

        // Buat sesi konseling confirmed + paid untuk user Asep
        SesiKonseling::create([
            'user_id'            => $user->id,
            'profil_konselor_id' => $profil->profil_konselor_id,
            'jadwal'             => now()->addDays(1),
            'media_konseling'    => 'chat',
            'deskripsi'          => 'Saya butuh konsultasi',
            'status'             => 'confirmed',
            'payment_status'     => 'paid',
            'payment_method'     => 'transfer',
            'approved_at'        => now()->subHour(),
        ]);
    }

    /**
     * TC.Dashboard.001 - Data sesi konseling terupdate secara akurat di Dashboard
     */
    public function testSinkronisasiSesiDashboard(): void
    {
        $user = User::where('email', 'asep@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->pause(1000)
                 ->assertPathIs('/home')
                 // Homepage menampilkan banner welcome dan data statistik
                 ->assertSee('Asep')
                 // Pastikan riwayat catatan konselor section ada
                 ->assertSee('Riwayat Catatan Konselor')
                 ->screenshot('TC_Dashboard_001_Pass');
        });
    }

    /**
     * TC.Dashboard.002 - Dashboard tidak error saat pengguna belum memiliki riwayat apapun
     */
    public function testDashboardAkunBaruTanpaRiwayat(): void
    {
        $user = User::where('email', 'akunbaru@example.com')->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                 ->visit('/home')
                 ->pause(1000)
                 ->assertPathIs('/home')
                 // Halaman tetap load tanpa error
                 ->assertSee('Akun Baru')
                 // Melihat pesan empty state pada bagian riwayat sesi
                 ->assertSee('Belum ada riwayat sesi konseling selesai')
                 ->screenshot('TC_Dashboard_002_Pass');
        });
    }
}
