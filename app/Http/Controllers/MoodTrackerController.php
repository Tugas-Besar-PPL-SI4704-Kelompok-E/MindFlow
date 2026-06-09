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

        // Jika user memilih untuk bercerita, arahkan ke halaman open question
        // sambil membawa ID hasil check instan agar bisa ditautkan.
        if ($request->input('wants_to_tell_story') == '1') {
            return redirect()->route('mood-tracker.open-question', ['check_instan_id' => $hasil->check_instan_id]);
        }
        
        $redirect = redirect()->route('mood-tracker.index')
            ->with('success', 'Mood berhasil disimpan! Skor kamu: ' . $skor . ' (' . $kategori . ')');

        if ($isBuruk) {
            $tips = [
                "Coba tarik napas dalam-dalam selama 5 detik, tahan 5 detik, dan hembuskan perlahan. Ulangi 3 kali.",
                "Menjauh sejenak dari layar atau aktivitasmu saat ini. Minum segelas air putih hangat.",
                "Pejamkan mata sejenak, fokus pada suara di sekitarmu, dan sadari bahwa perasaan berat ini hanya sementara.",
                "Coba tuliskan 3 hal kecil yang membuatmu bersyukur hari ini, sesederhana cuaca yang cerah atau makanan yang enak."
            ];
            $redirect->with('feedback_tip', $tips[array_rand($tips)]);
        }

        return $redirect;
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

        // Feedback empatik khusus untuk pengguna yang baru saja meluapkan isi hatinya
        $empatheticTip = "Terima kasih sudah berani jujur dan menuliskannya. Memindahkan isi kepala ke dalam tulisan adalah langkah awal yang luar biasa untuk melepaskan beban emosi. Jika kamu merasa butuh teman bercerita yang profesional, jangan ragu untuk menjadwalkan sesi konseling bersama kami ya.";

        return redirect()->route('mood-tracker.index')
            ->with('success', 'Terima kasih sudah bercerita. Jawabanmu telah tersimpan dengan aman.')
            ->with('feedback_tip', $empatheticTip);
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

        $hasil = HasilDass21::create([
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

        return redirect()->route('mood-tracker.mendalam.hasil', $hasil->dass21_id)
            ->with('success', 'Evaluasi DASS-21 berhasil disimpan. Berikut adalah hasilnya.');
    }

    /**
     * Tampilkan hasil pemeriksaan mendalam.
     */
    public function mendalamHasil($id)
    {
        $hasil = HasilDass21::where('user_id', Auth::id())->findOrFail($id);
        return view('pages.mood-tracker.hasil-mendalam', compact('hasil'));
    }
}
