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
    protected $description = 'Batalkan sesi konseling yang belum direspon dalam 3 detik untuk testing, atau 24 jam untuk production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // For testing: cancel after 3 seconds
        // For production: change to subHours(24)
        $expiredSessions = SesiKonseling::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subSeconds(3))
            ->get();

        $count = 0;
        foreach ($expiredSessions as $session) {
            $session->update([
                'status' => 'cancelled',
                'catatan_konselor' => 'Sesi dibatalkan otomatis oleh sistem karena melebihi batas waktu respons.',
            ]);

            // Notify user
            $session->user->notify(new SessionAutoCancelled($session));
            $count++;
        }

        $this->info("Berhasil membatalkan $count sesi yang kedaluwarsa.");
    }
}
