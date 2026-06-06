<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreKonselingRequest;
use App\Models\SesiKonseling;
use App\Models\ProfilKonselor;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(StoreKonselingRequest $request) 
    {
        $data = $request->validated();

        $jadwalDate = \Carbon\Carbon::parse($data['jadwal']);
        if ($jadwalDate->lt(now()->addHours(3))) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal tidak valid. Pemesanan tidak boleh mendadak, silakan pilih jadwal minimal 3 jam dari sekarang.');
        }

        $alreadyBooked = SesiKonseling::where('profil_konselor_id', $data['konselor_id'])
            ->where('jadwal', $data['jadwal'])
            ->whereIn('status', ['pending', 'confirmed', 'rescheduled'])
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal ini tidak tersedia. Pilih jadwal lain atau cek kembali ketersediaan konselor.');
        }

        $sesi = SesiKonseling::create([
            'user_id' => Auth::id(),
            'profil_konselor_id' => $data['konselor_id'],
            'jadwal' => $data['jadwal'],
            'media_konseling' => $data['media_konseling'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'payment_method' => $data['payment_method'],
            'payment_status' => 'paid',
            'status' => 'pending'
        ]);

        if (!empty($data['journals'])) {
            $sesi->journals()->attach($data['journals']);
        }

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
            'jadwal' => 'required|date',
            'reason' => 'nullable|string|max:255',
        ]);

        $jadwalDate = \Carbon\Carbon::parse($request->jadwal);
        if ($jadwalDate->lt(now()->addHours(3))) {
            return redirect()->back()
                ->with('error', 'Perubahan jadwal tidak valid. Jadwal baru harus minimal 3 jam dari sekarang.');
        }

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
            ->with('success', 'Jadwal konsultasi berhasil dibatalkan.');
    }

    public function checkExpiredPending(Request $request)
    {
        $cancelled = SesiKonseling::cancelExpiredPendingSessions();
        if ($cancelled) {
            session()->flash('error', 'Pesanan Anda dibatalkan oleh sistem karena melebihi 24 jam tanpa respon. Pembayaran akan dikembalikan.');
        }

        return response()->json(['cancelled' => (bool) $cancelled]);
    }

    public function clearExpiredNotification()
    {
        session()->forget('expired_cancelled_sessions');
        return response()->json(['success' => true]);
    }
}