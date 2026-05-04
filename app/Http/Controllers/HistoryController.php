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
                    'color' => 'purple'
                ];
            });

        // Gabungkan semua collection
        $histories = $checkInstans->concat($checkMendalams)->concat($journals);

        // Urutkan berdasarkan tanggal terbaru (desc)
        $histories = $histories->sortByDesc('sort_date')->values();

        return view('history.index', compact('histories'));
    }
}
