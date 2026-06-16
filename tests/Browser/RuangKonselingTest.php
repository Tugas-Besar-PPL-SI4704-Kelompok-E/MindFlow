<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RuangKonselingTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

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

        
        SesiKonseling::create([
            'user_id'            => $user->id,
            'profil_konselor_id' => $profil->profil_konselor_id,
            'jadwal'             => now(),
            'media_konseling'    => 'chat',
            'deskripsi'          => 'Saya butuh konsultasi',
            'status'             => 'confirmed',
            'payment_status'     => 'paid',
            'payment_method'     => 'transfer',
            'approved_at'        => now()->subHour(),
        ]);

        
        SesiKonseling::create([
            'user_id'            => $user->id,
            'profil_konselor_id' => $profil->profil_konselor_id,
            'jadwal'             => now()->subDays(3),
            'media_konseling'    => 'chat',
            'deskripsi'          => 'Sesi yang sudah dibatalkan',
            'status'             => 'cancelled',
            'payment_status'     => 'paid',
            'payment_method'     => 'transfer',
        ]);
    }

    


    public function testAksesRuangKonselingNormal(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        $sesi = SesiKonseling::where('user_id', $user->id)
                    ->where('status', 'confirmed')
                    ->first();

        $this->browse(function (Browser $browser) use ($user, $sesi) {
            $browser->loginAs($user)
                 ->visit('/sesi-konseling/' . $sesi->sesi_konseling_id . '/room')
                 ->pause(2000)
                 
                 ->assertSee('Dr. Konselor')
                 ->screenshot('TC_RuangKonseling_001_Pass');
        });
    }

    


    public function testAksesDitolakPadaSesiBatal(): void
    {
        $user = User::where('email', 'asep@example.com')->first();
        $sesiBatal = SesiKonseling::where('user_id', $user->id)
                        ->where('status', 'cancelled')
                        ->first();

        $this->browse(function (Browser $browser) use ($user, $sesiBatal) {
            
            $browser->loginAs($user)
                 ->visit('/sesi-konseling/' . $sesiBatal->sesi_konseling_id . '/room')
                 ->pause(1500)
                 
                 ->assertPathIsNot('/sesi-konseling/' . $sesiBatal->sesi_konseling_id . '/room')
                 ->screenshot('TC_RuangKonseling_002_Pass');
        });
    }
}
