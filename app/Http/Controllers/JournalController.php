<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    /**
     * Memastikan semua akses ke Controller ini harus login (terautentikasi)
     */
    public function __construct()
    {
        // Middleware auth dinonaktifkan sementara karena sistem login belum dibuat
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * Mengambil dan menampilkan semua riwayat jurnal khusus untuk user yang sedang login.
     */
    public function index()
    {
        // Ambil ID dari Auth user, secara default menggunakan ID 1 untuk keperluan testing
        $userId = Auth::id() ?? 1;

        // Ambil jurnal milik user tersebut, urutkan dari terbaru
        $journals = Journal::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get();

        // Data Kalender Mood (Dinamis & Dummy Placeholder)
        $currentMonth = \Carbon\Carbon::now()->translatedFormat('F'); // Contoh: "April"
        $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
        $currentDay = \Carbon\Carbon::now()->day;
        
        // Dummy placeholder untuk status mood berdasarkan tanggal bulan ini
        // Rencana: Hijau = Senang, Kuning = Biasa, Merah = Stres
        $moodData = [
            1 => 'senang',
            2 => 'biasa',
            3 => 'stres',
        ];

        return view('journals.index', compact('journals', 'currentMonth', 'daysInMonth', 'currentDay', 'moodData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('journals.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan input dari editor teks ke database dengan validasi.
     */
    public function store(Request $request)
    {
        // Validasi input: content wajib diisi dan bertipe string
        $request->validate([
            'content' => 'required|string',
        ]);

        // Simpan ke database
        Journal::create([
            'user_id' => Auth::id() ?? 1,
            'content' => $request->content,
        ]);

        return redirect()->route('journals.index')
                         ->with('success', 'Jurnal refleksi berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $journal = Journal::findOrFail($id);

        // Otorisasi: Cegah user mengedit jurnal milik orang lain
        if ($journal->user_id !== (Auth::id() ?? 1)) {
            abort(403, 'Anda tidak berhak mengakses jurnal ini.');
        }

        return view('journals.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $journal = Journal::findOrFail($id);

        // Otorisasi: Pastikan kepemilikannya sesuai
        if ($journal->user_id !== (Auth::id() ?? 1)) {
            abort(403, 'Akses ditolak.');
        }

        // Validasi
        $request->validate([
            'content' => 'required|string',
        ]);

        // Update data
        $journal->update([
            'content' => $request->content,
        ]);
        
        // Memaksa kolom timestamps 'updated_at' diperbarui ke waktu sekarang detik ini juga, 
        // walau isi teksnya tak ada yang dirubah sama sekali oleh user.
        $journal->touch();

        return redirect()->route('journals.index')
                         ->with('success', 'Jurnal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);

        // Otorisasi: Pastikan hanya pemilik yang bisa menghapus
        if ($journal->user_id !== (Auth::id() ?? 1)) {
            abort(403, 'Akses ditolak.');
        }

        // Hapus data
        $journal->delete();

        return redirect()->route('journals.index')
                         ->with('success', 'Jurnal berhasil dihapus.');
    }
}
