<?php
# 
namespace App\Http\Controllers;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\User;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedSpesialisasi = $request->input('spesialisasi');
        $availability = $request->input('ketersediaan');
        $query = ProfilKonselor::with(['user', 'sesiKonseling', 'counselorSchedules'])
            ->whereHas('user', fn ($q) => $q->where('status', 'approved'));

        if ($search) {
            $query->search($search);
        }

        if ($selectedSpesialisasi && $selectedSpesialisasi !== 'semua') {
            $query->filterSpecialization($selectedSpesialisasi);
        }

        if ($availability === 'tersedia') {
            $query->hasAvailability();
        }

        $konselors = $query->paginate(12)->withQueryString();
        $spesialisasiList = ProfilKonselor::distinct()->pluck('spesialisasi')->filter()->toArray();

        return view('konseling.index', compact(
            'konselors',
            'spesialisasiList',
            'search',
            'selectedSpesialisasi',
            'availability'
        ));
    }

    /**
     * PBI 28: Show detail of a specific counselor
     * Menampilkan biografi, keahlian, dan jadwal tersedia
     */
    public function show($id)
    {
        // PBI-45: Batalkan sesi yang sudah kedaluwarsa secara otomatis
        \App\Models\SesiKonseling::cancelExpiredPendingSessions();

        $konselor = ProfilKonselor::with(['user', 'sesiKonseling'])
            ->findOrFail($id);

        // Ambil sesi yang tersedia (belum penuh)
        $sesiTersedia = $konselor->sesiKonseling()
            ->where('status', '!=', 'penuh')
            ->orderBy('jadwal', 'asc')
            ->get();

        $bookedSchedules = $konselor->sesiKonseling()
            ->whereIn('status', ['pending', 'confirmed', 'rescheduled'])
            ->pluck('jadwal')
            ->toArray();

        return view('konseling.show', compact('konselor', 'sesiTersedia', 'bookedSchedules'));
    }

    /**
     * PBI 29: Booking a counseling session
     * Membuat janji konseling baru
     */
    public function book($konselorId, Request $request)
    {
        $request->validate([
            'sesi_konseling_id' => 'required|exists:sesi_konselings,id',
            'topik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);
        $sesi = SesiKonseling::findOrFail($request->sesi_konseling_id);
        if ($sesi->profil_konselor_id != $konselorId) {
            return back()->with('error', 'Sesi konseling tidak valid');
        }

        if ($sesi->status === 'penuh') {
            return back()->with('error', 'Jadwal sudah penuh, pilih jadwal lain');
        }

        return back()->with('success', 'Janji konseling berhasil dibuat!');
    }
    
    public static function getSpesialisasi()
    {
        return ProfilKonselor::distinct()
            ->pluck('spesialisasi')
            ->filter()
            ->toArray();
    }
}
