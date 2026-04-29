<?php

namespace App\Http\Controllers;

use App\Models\HasilCheckInstan;
use App\Models\HasilCheckMendalam;
use App\Models\HasilDass21;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodTrackerController extends Controller
{
    /**
     * Halaman index mood tracker (pilih singkat / mendalam).
     */
    public function index()
    {
        return view('pages.mood-tracker.index');
    }

    /**
     * Halaman pemeriksaan singkat (form emoji 1-10).
     */
    public function singkat()
    {
        return view('pages.mood-tracker.singkat');
    }

    /**
     * Simpan hasil pemeriksaan singkat.
     *
     * PBI: Fitur pemeriksaan singkat untuk pencatatan mood harian.
     *      Apabila mood sangat hancur, bisa memilih ke open question.
     * PBI: Logika sistem poin untuk pemeriksaan singkat.
     */
    public function singkatStore(Request $request)
    {
        $request->validate([
            'mood_score' => 'required|integer|min:1|max:10',
        ]);

        $skor = (int) $request->mood_score;
        $kategori = HasilCheckInstan::determineKategori($skor);
        $isBuruk = $skor <= 4;

        $hasil = HasilCheckInstan::create([
            'user_id'              => Auth::id() ?? 1,  // fallback ke 1 jika belum ada auth
            'poin_skor'            => $skor,
            'kategori_hasil'       => $kategori,
            'is_mendalam_offered'  => $isBuruk,
        ]);

        // Jika mood buruk dan user memilih untuk bercerita (via modal),
        // redirect ke open question dengan membawa check_instan_id
        // agar bisa di-link di tabel hasil_check_mendalams.
        // Logika redirect ini di-handle oleh JavaScript di frontend:
        //   - Jika skor <= 4, modal muncul → user klik "Ya, Ceritakan" → ke open-question
        //   - Jika skor > 4, form submit langsung → masuk ke sini → redirect back with success
        
        return redirect()->route('mood-tracker.index')
            ->with('success', 'Mood berhasil disimpan! Skor kamu: ' . $skor . ' (' . $kategori . ')');
    }

    /**
     * Halaman open question (PCL-5 context).
     */
    public function openQuestion(Request $request)
    {
        // Ambil check_instan_id jika diteruskan dari modal singkat
        $checkInstanId = $request->query('check_instan_id');
        return view('pages.mood-tracker.open-question', compact('checkInstanId'));
    }

    /**
     * Simpan jawaban open question.
     *
     * PBI: Fitur open question (uraian) tentang mood hari ini
     *      menggunakan instrumen DASS-21 & PCL-5 (menyesuaikan).
     */
    public function openQuestionStore(Request $request)
    {
        $request->validate([
            'open_answer'     => 'required|string|min:6',
            'check_instan_id' => 'nullable|integer',
        ]);

        HasilCheckMendalam::create([
            'check_instan_id' => $request->check_instan_id,
            'user_id'         => Auth::id() ?? 1,
            'jawaban_terbuka' => $request->open_answer,
        ]);

        return redirect()->route('mood-tracker.index')
            ->with('success', 'Terima kasih sudah bercerita. Jawabanmu telah tersimpan dengan aman.');
    }

    /**
     * Halaman pemeriksaan mendalam (DASS-21 form).
     */
    public function mendalam()
    {
        return view('pages.mood-tracker.mendalam');
    }

    /**
     * Simpan hasil pemeriksaan mendalam (DASS-21).
     *
     * PBI: Fitur pemeriksaan mendalam menggunakan instrumen DASS-21.
     * PBI: Logika sistem poin untuk pemeriksaan mendalam.
     *      Dari DASS-21 ditambahkan semua per pertanyaan.
     */
    public function mendalamStore(Request $request)
    {
        $request->validate([
            'responses'              => 'required|array|size:21',
            'responses.*.question_id'=> 'required|integer|min:1|max:21',
            'responses.*.score'      => 'required|integer|min:0|max:3',
        ]);

        $responses = $request->responses;

        // GUEST FLOW: Jika belum login, simpan di session → redirect ke register
        if (!Auth::check()) {
            $request->session()->put('guest_dass21_responses', $responses);

            return redirect()->route('register')
                ->with('info', 'Untuk melihat hasil pemeriksaan, silakan daftar akun terlebih dahulu.');
        }

        // AUTHENTICATED USER: Hitung dan simpan ke database
        $scores = HasilDass21::hitungSkor($responses);

        HasilDass21::create([
            'user_id'            => Auth::id(),
            'skor_depresi'       => $scores['skor_depresi'],
            'skor_kecemasan'     => $scores['skor_kecemasan'],
            'skor_stres'         => $scores['skor_stres'],
            'total_skor'         => $scores['total_skor'],
            'kategori_depresi'   => $scores['kategori_depresi'],
            'kategori_kecemasan' => $scores['kategori_kecemasan'],
            'kategori_stres'     => $scores['kategori_stres'],
            'detail_jawaban'     => $responses,
        ]);

        return redirect()->route('mood-tracker.index')
            ->with('success', 'Evaluasi DASS-21 berhasil disimpan. Terima kasih telah meluangkan waktumu.');
    }
}
