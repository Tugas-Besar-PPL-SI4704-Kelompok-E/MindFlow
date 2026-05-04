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
        $query = ProfilKonselor::with(['user', 'sesiKonseling']);

        $spesialisasi = $request->input('spesialisasi');
        
        // Menggunakan pencarian 'like' untuk lebih fleksibel seperti di HEAD
        if ($request->has('spesialisasi') && $request->spesialisasi != '') {
            $query->where('spesialisasi', 'like', '%' . $request->spesialisasi . '%');
        }
        
        $query->whereHas('user', function ($q) {
            $q->where('status', 'approved');
        });
        
        $konselors = $query->paginate(10);

        return view('konseling.index', compact('konselors', 'spesialisasi'));
    }

    /**
     * PBI 28: Show detail of a specific counselor
     * Menampilkan biografi, keahlian, dan jadwal tersedia
     */
    public function show($id)
    {
        $konselor = ProfilKonselor::with(['user', 'sesiKonseling'])
            ->findOrFail($id);

        // Ambil sesi yang tersedia (belum penuh)
        $sesiTersedia = $konselor->sesiKonseling()
            ->where('status', '!=', 'penuh')
            ->orderBy('jadwal', 'asc')
            ->get();

        return view('konseling.show', compact('konselor', 'sesiTersedia'));
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
