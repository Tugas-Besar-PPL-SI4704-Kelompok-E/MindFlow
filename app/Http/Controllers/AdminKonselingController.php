<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SesiKonseling;
use Illuminate\Support\Facades\DB;
use App\Notifications\SesiConfirmed;
use App\Notifications\SesiCancelled;

class AdminKonselingController extends Controller
{
    public function confirm($id)
    {
        $sesi = SesiKonseling::findOrFail($id);

        if ($sesi->status === 'confirmed') {
            return back()->with('info', 'Sesi sudah terkonfirmasi.');
        }

        DB::transaction(function () use ($sesi) {
            $sesi->update(['status' => 'confirmed']);
        });

        // Notify user outside transaction
        try {
            $sesi->user->notify(new SesiConfirmed($sesi));
        } catch (\Exception $e) {
            // Do not fail the request if notification fails; log if needed
        }

        return back()->with('success', 'Sesi berhasil dikonfirmasi.');
    }

    public function cancel(Request $request, $id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        $reason = $request->input('reason');

        DB::transaction(function () use ($sesi) {
            $sesi->update([
                'status' => 'cancelled',
                'payment_status' => 'refunded',
            ]);
        });

        try {
            $sesi->user->notify(new SesiCancelled($sesi, $reason ?? null));
        } catch (\Exception $e) {
            // ignore notification failure
        }

        return back()->with('success', 'Sesi dibatalkan. Pembayaran akan dikembalikan.');
    }
}
