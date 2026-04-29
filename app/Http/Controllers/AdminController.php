<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\LaporanForum;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * PBI 42: Dashboard metrik — menggunakan data real dari database.
     */
    public function index()
    {
        $data = [
            'totalUsers'      => User::where('role', 'user')->count(),
            'totalArticles'   => 0, // Tabel artikels belum ada modelnya, dummy
            'totalApplicants' => 0, // Tabel calon_konselors — dummy
            'totalReports'    => LaporanForum::where('status_tindak_lanjut', 'pending')->count(),
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * PBI 38: Laporan pelanggaran — menggunakan data real dari database.
     */
    public function laporan()
    {
        $reports = LaporanForum::with(['forum', 'pelapor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.laporan', compact('reports'));
    }

    /**
     * PBI 40: Eksekusi hapus postingan forum secara permanen.
     */
    public function hapusPostingan($id)
    {
        $forum = Forum::findOrFail($id);
        $forum->delete();

        return back()->with('success', "Postingan \"{$forum->judul_thread}\" telah dihapus secara permanen.");
    }

    /**
     * PBI 37: Page rekrutmen aplikan (masih dummy karena fitur apply belum diimplementasi).
     */
    public function rekrutmen()
    {
        $applicants = collect([
            (object)[
                'id' => 1,
                'nama' => 'Dr. Aisyah Putri',
                'email' => 'aisyah.putri@klinikjiwa.com',
                'spesialisasi' => 'Klinis & Depresi',
                'tanggal_daftar' => '18 Apr 2026',
                'status' => 'Menunggu Review'
            ],
            (object)[
                'id' => 2,
                'nama' => 'Bima Satria, M.Psi',
                'email' => 'bimasatria@gmail.com',
                'spesialisasi' => 'Konseling Remaja',
                'tanggal_daftar' => '19 Apr 2026',
                'status' => 'Menunggu Review'
            ]
        ]);

        return view('admin.rekrutmen', compact('applicants'));
    }

    /**
     * PBI 39: Pengelolaan kategori spesialisasi konselor.
     */
    public function spesialisasi()
    {
        return view('admin.spesialisasi');
    }
}