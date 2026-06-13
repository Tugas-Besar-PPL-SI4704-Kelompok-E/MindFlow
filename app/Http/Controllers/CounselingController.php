<?php
# 
namespace App\Http\Controllers;

use App\Models\ProfilKonselor;
use App\Models\SesiKonseling;
use App\Models\CounselorSchedule;
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

        // Ambil jadwal kerja aktif konselor (hari + jam)
        $counselorSchedules = CounselorSchedule::where('profil_konselor_id', $id)
            ->where('is_active', true)
            ->get()
            ->map(function ($s) {
                return [
                    'hari' => strtolower($s->hari),
                    'jam_mulai' => $s->jam_mulai,
                    'jam_selesai' => $s->jam_selesai,
                ];
            })->toArray();

        $userJournals = \App\Models\Journal::where('user_id', auth()->id())->latest()->get();

        // Generate available slots for the next 30 days based on counselor schedules
        $minBooking = now()->addHours(3);
        $endDate = now()->addDays(30)->endOfDay();

        $bookedNormalized = collect($bookedSchedules)->map(function ($b) {
            return \Carbon\Carbon::parse($b)->format('Y-m-d H:i');
        })->toArray();

        $dayNames = ['minggu','senin','selasa','rabu','kamis','jumat','sabtu'];
        $dayNamesDisplay = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $availableSlots = [];

        $cursor = $minBooking->copy()->startOfDay();
        while ($cursor->lte($endDate)) {
            $dayName = $dayNames[$cursor->dayOfWeek];
            $dayNameDisplay = $dayNamesDisplay[$cursor->dayOfWeek];

            foreach ($counselorSchedules as $s) {
                if ($s['hari'] !== $dayName) continue;

                $slotStart = \Carbon\Carbon::parse($cursor->format('Y-m-d') . ' ' . $s['jam_mulai']);
                $slotEnd = \Carbon\Carbon::parse($cursor->format('Y-m-d') . ' ' . $s['jam_selesai']);

                for ($t = $slotStart->copy(); $t->lt($slotEnd); $t->addMinutes(60)) {
                    if ($t->lt($minBooking)) continue;

                    $fmt = $t->format('Y-m-d H:i');
                    if (in_array($fmt, $bookedNormalized)) continue;

                    $availableSlots[] = [
                        'datetime' => $fmt,
                        'display' => $dayNameDisplay . ', ' . $t->format('d F Y H:i'),
                        'date' => $t->format('d F Y'),
                        'time' => $t->format('H:i'),
                        'dayname' => $dayNameDisplay
                    ];
                }
            }

            $cursor->addDay();
        }

        return view('konseling.show', compact('konselor', 'sesiTersedia', 'bookedSchedules', 'userJournals', 'counselorSchedules', 'availableSlots'));
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

    /**
     * PBI 60: Page Konseling (Live Session Room)
     * Menampilkan antarmuka sesi konseling sesuai media yang dipilih (video, voice, chat).
     */
    public function room($id)
    {
        $sesi = SesiKonseling::with(['user', 'profilKonselor.user'])->findOrFail($id);

        // Otorisasi: Hanya user (pasien) atau konselor terkait yang boleh mengakses
        $userId = auth()->id();
        $isPatient = $sesi->user_id === $userId;
        $isCounselor = $sesi->profilKonselor && $sesi->profilKonselor->user_id === $userId;

        if (!$isPatient && !$isCounselor) {
            abort(403, 'Anda tidak memiliki akses ke ruangan ini.');
        }

        // Cek status sesi (misal hanya izinkan jika confirmed atau ongoing)
        // Kita izinkan jika statusnya tidak 'cancelled' atau 'pending'
        if (in_array($sesi->status, ['pending', 'cancelled', 'rejected'])) {
            return redirect()->back()->with('error', 'Sesi ini belum aktif atau sudah dibatalkan.');
        }

        return view('konseling.room', compact('sesi', 'isPatient', 'isCounselor'));
    }

    public function getChat($id)
    {
        $sesi = SesiKonseling::findOrFail($id);
        
        $userId = auth()->id();
        $isPatient = $sesi->user_id === $userId;
        $isCounselor = $sesi->profilKonselor && $sesi->profilKonselor->user_id === $userId;

        if (!$isPatient && !$isCounselor) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = \App\Models\PesanKonseling::with('pengirim')
            ->where('sesi_konseling_id', $id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'pengirim_id' => $msg->pengirim_id,
                    'nama_pengirim' => $msg->pengirim->nama_asli ?? $msg->pengirim->nama_samaran,
                    'isi_pesan' => $msg->isi_pesan,
                    'waktu' => $msg->created_at->format('H:i'),
                ];
            });

        return response()->json(['messages' => $messages, 'current_user_id' => $userId]);
    }

    public function sendChat(Request $request, $id)
    {
        $request->validate(['isi_pesan' => 'required|string']);

        $sesi = SesiKonseling::findOrFail($id);
        
        $userId = auth()->id();
        $isPatient = $sesi->user_id === $userId;
        $isCounselor = $sesi->profilKonselor && $sesi->profilKonselor->user_id === $userId;

        if (!$isPatient && !$isCounselor) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pesan = \App\Models\PesanKonseling::create([
            'sesi_konseling_id' => $id,
            'pengirim_id' => $userId,
            'isi_pesan' => $request->isi_pesan,
        ]);

        return response()->json(['success' => true, 'pesan' => $pesan]);
    }
    
    public static function getSpesialisasi()
    {
        return ProfilKonselor::distinct()
            ->pluck('spesialisasi')
            ->filter()
            ->toArray();
    }
}
