<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminPbiTest extends DuskTestCase
{
    use DatabaseMigrations;

    


    public function test_admin_pbis(): void
    {
        
        $admin = User::factory()->create([
            'email' => 'admin_dusk@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            
            
            $browser->visit('/login')
                    ->waitFor('#email', 5)
                    ->type('#email', $admin->email)
                    ->type('#password', 'password123')
                    ->press('#loginBtn')
                    ->pause(2000); 

            
            $browser->visit('/admin/dashboard')
                    ->pause(1500)
                    ->screenshot('PBI-42-Dashboard-Metrik');

            
            $browser->visit('/admin/rekrutmen')
                    ->pause(1500)
                    ->screenshot('PBI-37-Rekrutmen-Konselor');

            
            $browser->visit('/admin/laporan')
                    ->pause(1500)
                    ->screenshot('PBI-38-Laporan-Pelanggaran');

            
            $browser->visit('/admin/spesialisasi')
                    ->pause(1500)
                    ->screenshot('PBI-39-Pengelolaan-Spesialisasi');
            
            
            $browser->visit('/admin/laporan')
                    ->pause(1500)
                    ->screenshot('PBI-40-Halaman-Laporan-Dan-Hapus');

            
            $browser->visit('/home') 
                    ->click('#profileBtn')
                    ->waitFor('#btn-admin-logout', 5)
                    ->click('#btn-admin-logout')
                    ->pause(1000);
        });
    }
}
