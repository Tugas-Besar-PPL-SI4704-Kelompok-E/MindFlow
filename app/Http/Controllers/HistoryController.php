<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HasilCheckInstan;
use App\Models\HasilCheckMendalam;
use App\Models\Journal;

class HistoryController extends Controller
{
    /**
     * Memastikan semua akses ke Controller ini terautentikasi.
     */
    public function __construct()
    {
        // Middleware auth dinonaktifkan sementara menyesuaikan dengan JournalController
        // $this->middleware('auth');
    }

    /**
     * Menampilkan halaman riwayat lengkap
     */
    public function index()
    {
        $userId = Auth::id() ?? 1;

        // Ambil data Pengecekan Singkat
        $checkInstans = HasilCheckInstan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'type' => 'Pengecekan Singkat',
                    'date' => $item->created_at,
                    'status' => 'Selesai (' . $item->kategori_hasil . ')',
                    'sort_date' => $item->created_at,
                    'icon' => 'zap', // feather icon name or class
                    'color' => 'blue'
                ];
            });

        // Ambil data Pengecekan Mendalam
        $checkMendalams = HasilCheckMendalam::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'type' => 'Pengecekan Mendalam',
                    'date' => $item->created_at,
                    'status' => 'Selesai',
                    'sort_date' => $item->created_at,
                    'icon' => 'search',
                    'color' => 'indigo'
                ];
            });

        // Ambil data Jurnal
        $journals = Journal::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'type' => 'Pengisian Jurnal',
                    'date' => $item->updated_at,
                    'status' => 'Selesai',
                    'sort_date' => $item->updated_at,
                    'icon' => 'book-open',
                    'color' => 'purple',
                    'note' => null,
                    'sesi_id' => null
                ];
            });

        // Ambil data Sesi Konseling (PBI 36)
        $sesiKonselings = \App\Models\SesiKonseling::where('user_id', $userId)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'type' => 'Sesi Konseling',
                    'date' => $item->updated_at,
                    'status' => 'Selesai',
                    'sort_date' => $item->updated_at,
                    'icon' => 'users',
                    'color' => 'emerald',
                    'note' => $item->catatan_konselor,
                    'sesi_id' => $item->sesi_konseling_id
                ];
            });

        // Pastikan model lama memiliki key 'note' dan 'sesi_id'
        $checkInstans = $checkInstans->map(function ($item) {
            $item->note = null;
            $item->sesi_id = null;
            return $item;
        });

        $checkMendalams = $checkMendalams->map(function ($item) {
            $item->note = null;
            $item->sesi_id = null;
            return $item;
        });

        // Gabungkan semua collection
        $histories = $checkInstans->concat($checkMendalams)->concat($journals)->concat($sesiKonselings);

        // Urutkan berdasarkan tanggal terbaru (desc)
        $histories = $histories->sortByDesc('sort_date')->values();

        return view('history.index', compact('histories'));
    }
}
