<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PBI41Hukuman extends DuskTestCase
{
    


    public function test_tc_rpa_001_punish_user_positif(): void
    {
        $admin = User::where('email', 'admin@mindflow.id')->firstOrFail();

        $report = null;
        $pelanggar = null;

        $threadReport = \App\Models\ThreadReport::whereHas('thread.user', function ($q) {
            $q->where('status', '!=', 'muted')->orWhereNull('status');
        })->first();

        if ($threadReport) {
            $report = $threadReport;
            $pelanggar = $threadReport->thread->user;
        } else {
            $replyReport = \App\Models\ReplyReport::whereHas('reply.user', function ($q) {
                $q->where('status', '!=', 'muted')->orWhereNull('status');
            })->first();

            if ($replyReport) {
                $report = $replyReport;
                $pelanggar = $replyReport->reply->user;
            }
        }

        if (!$report || !$pelanggar) {
            throw new \Exception("Tidak ada data laporan pelanggaran dengan pelanggar yang belum di-mute di database.");
        }

        $this->browse(function (Browser $browser) use ($admin, $pelanggar) {
            $browser->loginAs($admin)
                    ->visit('/admin/laporan')
                    ->assertPathIs('/admin/laporan')
                    ->assertSee('Daftar Laporan Pelanggaran')
                    ->script("openPunishModal({$pelanggar->id}, '" . addslashes($pelanggar->nama_samaran ?? $pelanggar->nama_asli) . "');");

            $browser->pause(500)
                    ->waitFor('#punishModal', 5)
                    ->assertVisible('#punishModal')

                    ->select('punishment_type', 'mute')
                    ->select('duration', '24')
                    ->type('reason', 'Komentar tidak sopan pada postingan forum.')
                    ->press('Simpan Hukuman')
                    ->pause(1500)
                    ->assertPathIs('/admin/laporan')
                    ->assertSee('Hukuman berhasil dijatuhkan kepada pengguna');
        });
    }

    


    public function test_tc_rpa_002_punish_user_negatif_kosong(): void
    {
        $admin = User::where('email', 'admin@mindflow.id')->firstOrFail();

        $report = null;
        $pelanggar = null;

        $threadReport = \App\Models\ThreadReport::whereHas('thread.user', function ($q) {
            $q->where('status', '!=', 'muted')->orWhereNull('status');
        })->first();

        if ($threadReport) {
            $report = $threadReport;
            $pelanggar = $threadReport->thread->user;
        } else {
            $replyReport = \App\Models\ReplyReport::whereHas('reply.user', function ($q) {
                $q->where('status', '!=', 'muted')->orWhereNull('status');
            })->first();

            if ($replyReport) {
                $report = $replyReport;
                $pelanggar = $replyReport->reply->user;
            }
        }

        if (!$report || !$pelanggar) {
            throw new \Exception("Tidak ada data laporan pelanggaran dengan pelanggar yang belum di-mute di database.");
        }

        $this->browse(function (Browser $browser) use ($admin, $pelanggar) {
            $browser->loginAs($admin)
                    ->visit('/admin/laporan')
                    ->assertPathIs('/admin/laporan')
                    ->script("openPunishModal({$pelanggar->id}, '" . addslashes($pelanggar->nama_samaran ?? $pelanggar->nama_asli) . "');");

            $browser->pause(500)
                    ->waitFor('#punishModal', 5)
                    ->clear('reason')
                    ->press('Simpan Hukuman');

            $errorMessage = $browser->script("return document.querySelector('textarea[name=reason]').validationMessage;")[0];
            $this->assertNotEmpty($errorMessage);
        });
    }
}
