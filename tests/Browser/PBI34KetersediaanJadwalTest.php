<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\ProfilKonselor;

class PBI34KetersediaanJadwalTest extends DuskTestCase
{
    use DatabaseTruncation;

    /**
     * Test konselor can add and view their schedules
     */
    public function test_konselor_can_manage_schedule(): void
    {
        $this->browse(function (Browser $browser) {
            // Create user with konselor role
            $user = User::factory()->create([
                'role' => 'konselor',
                'status' => 'approved'
            ]);

            // Create counselor profile
            ProfilKonselor::factory()->create([
                'user_id' => $user->id,
                'nama' => 'Konselor Jane Doe',
                'spesialisasi' => 'Klinis',
            ]);

            $browser->loginAs($user)
                    ->visit('/konselor/counselor-schedules')
                    ->assertSee('Ketersediaan Jadwal')
                    ->press('+ Tambah Jadwal')
                    ->pause(1000)
                    ->assertSee('Tambah Jadwal Ketersediaan')
                    ->select('hari', 'Jumat')
                    ->keys('input[name=jam_mulai]', '09', '00', 'A') // Using keys for time input formatting issues in dusk sometimes
                    ->keys('input[name=jam_selesai]', '15', '00', 'P')
                    ->press('Tambah')
                    ->pause(1000)
                    ->assertSee('Jadwal berhasil ditambahkan')
                    ->assertSee('Jumat')
                    ->assertSee('Aktif');
        });
    }
}
