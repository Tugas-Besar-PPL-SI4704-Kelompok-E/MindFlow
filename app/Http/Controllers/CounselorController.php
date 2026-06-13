<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SesiKonseling;
use App\Models\Spesialisasi;
use Carbon\Carbon;

class CounselorController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk konselor.
     */
    public function index()
    {
        // PBI-45: Batalkan sesi yang sudah kedaluwarsa secara otomatis
        \App\Models\SesiKonseling::cancelExpiredPendingSessions();

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
        // PBI-45: Batalkan sesi yang sudah kedaluwarsa secara otomatis
        \App\Models\SesiKonseling::cancelExpiredPendingSessions();

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
        // PBI-45: Batalkan sesi yang sudah kedaluwarsa secara otomatis
        \App\Models\SesiKonseling::cancelExpiredPendingSessions();

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
            $sesi->update([
                'status' => 'cancelled',
                'payment_status' => 'refunded',
            ]);
        }

        return redirect()->back()->with('success', 'Pengajuan perubahan jadwal telah ditolak. Pembayaran akan dikembalikan jika sesi dibatalkan.');
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

        if ($sesi->payment_status === 'paid') {
            $profil = $sesi->profilKonselor;
            $amount = $profil->harga_per_sesi ?? 0;

            \App\Models\Transaction::create([
                'profil_konselor_id' => $profil->profil_konselor_id,
                'sesi_konseling_id' => $sesi->sesi_konseling_id,
                'amount' => $amount,
                'type' => 'deposit',
                'status' => 'approved',
                'description' => 'Honorarium Sesi Konseling #' . $sesi->sesi_konseling_id,
            ]);

            $profil->increment('saldo', $amount);
        }

        return redirect()->back()->with('success', 'Catatan evaluasi berhasil disimpan, sesi telah selesai, dan honorarium berhasil dicatat.');
    }

    /**
     * PBI 62: Pengaturan Profil dan Jadwal Konselor
     */
    public function settings()
    {
        $user = Auth::user();
        $profil = $user->profilKonselor;
        $spesialisasis = Spesialisasi::where('is_active', true)->orderBy('nama')->get();

        return view('konselor.settings', compact('user', 'profil', 'spesialisasis'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $profil = $user->profilKonselor;

        $request->validate([
            // Validasi Akun
            'nama_asli' => 'required|string|max:255',
            'nama_samaran' => 'required|string|max:255|unique:users,nama_samaran,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            // Validasi Profil Profesional
            'spesialisasi' => 'required|string|max:255',
            'no_sipp' => 'required|string|max:100',
            'harga_per_sesi' => 'required|numeric|min:0',
            'biografi' => 'nullable|string',
            'keahlian' => 'nullable|string',
        ]);

        // Update Akun
        $user->nama_asli = $request->nama_asli;
        $user->nama_samaran = $request->nama_samaran;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update Profil Profesional
        if ($profil) {
            $profil->update([
                'nama' => $request->nama_asli, // sinkronisasi nama asli ke tabel profil
                'spesialisasi' => $request->spesialisasi,
                'harga_per_sesi' => $request->harga_per_sesi,
                'no_sipp' => $request->no_sipp,
                'biografi' => $request->biografi,
                'keahlian' => $request->keahlian,
            ]);
        }

        return back()->with('success', 'Pengaturan profil profesional berhasil diperbarui!');
    }

    public function dompet()
    {
        $user = Auth::user();
        $profil = $user->profilKonselor;

        if (!$profil) {
            abort(404);
        }

        $transactions = \App\Models\Transaction::where('profil_konselor_id', $profil->profil_konselor_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('konselor.dompet', compact('profil', 'transactions'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:150',
        ]);

        $profil = Auth::user()->profilKonselor;

        if ($request->amount > $profil->saldo) {
            return redirect()->back()->withErrors(['amount' => 'Saldo tidak mencukupi untuk melakukan penarikan.']);
        }

        \App\Models\Transaction::create([
            'profil_konselor_id' => $profil->profil_konselor_id,
            'amount' => $request->amount,
            'type' => 'withdrawal',
            'status' => 'pending',
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'description' => 'Penarikan Dana ke ' . $request->bank_name . ' (' . $request->account_number . ')',
        ]);

        $profil->decrement('saldo', $request->amount);

        return redirect()->back()->with('success', 'Permintaan penarikan dana berhasil diajukan dan sedang diproses oleh admin.');
    }
}
