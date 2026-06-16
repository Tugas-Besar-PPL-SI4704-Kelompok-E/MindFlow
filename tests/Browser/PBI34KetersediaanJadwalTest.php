<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\ProfilKonselor;

class PBI34KetersediaanJadwalTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_konselor_can_manage_schedule(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'role' => 'konselor',
                'status' => 'approved'
            ]);

            ProfilKonselor::factory()->create([
                'user_id' => $user->id,
                'nama' => 'Konselor Jane Doe',
                'spesialisasi' => 'Klinis',
            ]);

            $browser->loginAs($user)
                    ->visit('/konselor/counselor-schedules')
                    ->assertSee('Ketersediaan Waktu')
                    ->press('+ Tambah Jadwal')
                    ->pause(1000)
                    ->assertSee('Tambah Jadwal Ketersediaan')
                    ->select('hari', 'Jumat')
                    ->keys('input[name=jam_mulai]', '09', '00', 'A')
                    ->keys('input[name=jam_selesai]', '15', '00', 'P')
                    ->press('Tambah')
                    ->pause(1000)
                    ->assertSee('Jadwal berhasil ditambahkan')
                    ->assertSee('Jumat')
                    ->assertSee('Aktif');
        });
    }
}
