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
            'konselor_id' => 'required|exists:profil_konselors,profil_konselor_id',
            'jadwal' => 'required',
        ]);

        SesiKonseling::create([
            'user_id' => Auth::id(),
            'profil_konselor_id' => $request->konselor_id,
            'jadwal' => $request->jadwal,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil dibuat! Menunggu konfirmasi.');
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
        ]);

        $sesi = SesiKonseling::findOrFail($id);
        
        $sesi->update([
            'jadwal' => $request->jadwal,
            'status' => 'rescheduled'
        ]);

        return redirect()->route('konseling.show', $sesi->profil_konselor_id)
            ->with('info', 'Jadwal sesi telah berhasil diubah!');
    }

    public function cancel($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        $konselorId = $sesi->profil_konselor_id;
        
        $sesi->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('konseling.show', $konselorId)
            ->with('error', 'Reservasi telah dibatalkan.');
    }
}