<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SesiKonseling;
use Carbon\Carbon;
use App\Notifications\SessionAutoCancelled;

class CancelExpiredSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan sesi konseling yang belum direspon oleh konselor dalam 24 jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredSessions = SesiKonseling::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subSeconds(3))
            ->get();

        $count = 0;
        foreach ($expiredSessions as $session) {
            $session->update([
                'status' => 'cancelled',
                'catatan_konselor' => 'Sesi dibatalkan otomatis oleh sistem karena konselor tidak memberikan respons dalam 10 detik.',
            ]);

            // Notify user
            $session->user->notify(new SessionAutoCancelled($session));
            $count++;
        }

        $this->info("Berhasil membatalkan $count sesi yang kedaluwarsa.");
    }
}
