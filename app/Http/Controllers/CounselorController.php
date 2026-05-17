<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SesiKonseling;
use Carbon\Carbon;

class CounselorController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk konselor.
     */
    public function index()
    {
        $konselorId = Auth::user()->profilKonselor->profil_konselor_id ?? null;

        $sesiHariIni = 0;
        $pasienAktif = 0;

        if ($konselorId) {
            $sesiHariIni = SesiKonseling::where('profil_konselor_id', $konselorId)
                ->whereDate('jadwal', Carbon::today())
                ->count();

            $pasienAktif = SesiKonseling::where('profil_konselor_id', $konselorId)
                ->distinct('user_id')
                ->count('user_id');
        }

        return view('konselor.dashboard', compact('sesiHariIni', 'pasienAktif'));
    }

    public function jadwal()
    {
        $konselorId = Auth::user()->profilKonselor->profil_konselor_id ?? null;
        
        $sesi = [];
        if ($konselorId) {
            $sesi = SesiKonseling::with('user')
                ->where('profil_konselor_id', $konselorId)
                ->orderBy('jadwal', 'desc')
                ->get();
        }

        return view('konselor.jadwal', compact('sesi'));
    }

    public function pasien()
    {
        $konselorId = Auth::user()->profilKonselor->profil_konselor_id ?? null;
        
        $pasien = [];
        if ($konselorId) {
            // Get all sessions and then get unique users
            $pasien = SesiKonseling::with('user')
                ->where('profil_konselor_id', $konselorId)
                ->get()
                ->unique('user_id')
                ->map(function ($sesi) {
                    return $sesi->user;
                });
        }

        return view('konselor.pasien', compact('pasien'));
    }

    public function acceptSession($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        
        if ($sesi->profil_konselor_id !== Auth::user()->profilKonselor->profil_konselor_id) {
            abort(403);
        }

        if ($sesi->status === 'change_requested' && $sesi->requested_jadwal) {
            $sesi->update([
                'jadwal' => $sesi->requested_jadwal,
                'requested_jadwal' => null,
                'request_reason' => null,
                'status' => 'confirmed'
            ]);
        } else {
            $sesi->update(['status' => 'confirmed']);
        }

        return redirect()->back()->with('success', 'Perubahan jadwal berhasil dikonfirmasi.');
    }

    public function rejectSession($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        
        if ($sesi->profil_konselor_id !== Auth::user()->profilKonselor->profil_konselor_id) {
            abort(403);
        }

        if ($sesi->status === 'change_requested') {
            $sesi->update([
                'requested_jadwal' => null,
                'request_reason' => null,
                'status' => 'rejected'
            ]);
        } else {
            $sesi->update(['status' => 'cancelled']);
        }

        return redirect()->back()->with('success', 'Pengajuan perubahan jadwal telah ditolak.');
    }

    public function submitEvaluasi(Request $request, $id)
    {
        $request->validate([
            'catatan_konselor' => 'required|string',
        ]);

        $sesi = SesiKonseling::findOrFail($id);
        
        if ($sesi->profil_konselor_id !== Auth::user()->profilKonselor->profil_konselor_id) {
            abort(403);
        }

        $sesi->update([
            'catatan_konselor' => $request->catatan_konselor,
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Catatan evaluasi berhasil disimpan dan sesi telah selesai.');
    }
}
