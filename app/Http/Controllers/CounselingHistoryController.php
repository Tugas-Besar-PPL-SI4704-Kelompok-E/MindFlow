<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SesiKonseling;

class CounselingHistoryController extends Controller
{
    /**
     * Menampilkan riwayat sesi konseling dengan filter rentang waktu.
     */
    public function index(Request $request)
    {
        // PBI-45: Batalkan sesi yang sudah kedaluwarsa secara otomatis
        \App\Models\SesiKonseling::cancelExpiredPendingSessions();

        $range = $request->input('range', 'all');
        $userId = Auth::id() ?? 1;

        $query = SesiKonseling::where('user_id', $userId)
            ->whereIn('status', ['completed', 'cancelled']) // Usually history shows completed/cancelled
            ->with('profilKonselor.user');
            
        if ($range !== 'all') {
            $query->byTimeRange($range);
        }
        
        $histories = $query->orderBy('jadwal', 'desc')->get();
        
        return view('konseling.history', compact('histories', 'range'));
    }
}
