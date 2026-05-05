<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SesiKonseling;
use App\Models\ProfilKonselor;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'konselor_id' => 'required|exists:profil_konselor,profil_konselor_id',
            'jadwal' => 'required',
            'deskripsi' => 'required|string|max:255',
        ]);

        $alreadyBooked = SesiKonseling::where('profil_konselor_id', $request->konselor_id)
            ->where('jadwal', $request->jadwal)
            ->whereIn('status', ['pending', 'confirmed', 'rescheduled'])
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal ini tidak tersedia. Pilih jadwal lain atau cek kembali ketersediaan konselor.');
        }

        SesiKonseling::create([
            'user_id' => Auth::id(),
            'profil_konselor_id' => $request->konselor_id,
            'jadwal' => $request->jadwal,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Sesi konsultasi berhasil direservasi. Menunggu konfirmasi.');
    }

    public function edit($id)
    {
        $sesi = SesiKonseling::with('profilKonselor')->findOrFail($id);
        return view('konseling.edit', compact('sesi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal' => 'required',
            'reason' => 'nullable|string|max:255',
        ]);

        $sesi = SesiKonseling::findOrFail($id);

        if ($sesi->user_id !== Auth::id()) {
            abort(403);
        }

        $sesi->update([
            'requested_jadwal' => $request->jadwal,
            'request_reason' => $request->reason,
            'status' => 'change_requested'
        ]);

        return redirect()->route('konseling.show', $sesi->profil_konselor_id)
            ->with('success', 'Pengajuan perubahan jadwal berhasil dikirim! Menunggu konfirmasi konselor.');
    }

    public function cancel($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        $konselorId = $sesi->profil_konselor_id;
        
        $sesi->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('konseling.show', $konselorId)
            ->with('error', 'Sesi konsultasi Anda telah dibatalkan.');
    }
}