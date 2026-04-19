<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SesiKonseling; // <--- WAJIB ADA agar tidak error 'Class not found'
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request) 
    {
        // PBI 29: Simpan data pesanan sesi konseling ke database
        SesiKonseling::create([
            'user_id' => Auth::id(), // Mengambil ID user yang sedang login
            'profil_konselor_id' => $request->konselor_id,
            'jadwal' => $request->jadwal,
            'status' => 'pending'
        ]);

        // PBI 30: Sistem notifikasi reservasi sukses via session flash data
        return redirect()->back()->with('success', 'Reservasi berhasil dibuat! Menunggu konfirmasi.');
    }

    public function updateJadwal(Request $request, $id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        
        // PBI 31: Update waktu sesi
        $sesi->update([
            'jadwal' => $request->jadwal_baru,
            'status' => 'rescheduled'
        ]);

        return redirect()->back()->with('info', 'Jadwal sesi telah berhasil diubah.');
    }
}