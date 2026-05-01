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
            'totalReports'    => \App\Models\ThreadReport::count() + \App\Models\ReplyReport::count(),
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * PBI 38: Laporan pelanggaran — menggunakan data real dari database.
     */
    public function laporan()
    {
        $threadReports = \App\Models\ThreadReport::with(['thread', 'user'])->get()->map(function($r) {
            return (object)[
                'type' => 'thread',
                'id' => $r->id,
                'target_id' => $r->thread_id,
                'pelapor' => $r->user,
                'konten' => $r->thread ? $r->thread->content : 'Postingan telah dihapus',
                'alasan' => $r->reason,
                'created_at' => $r->created_at,
                'is_deleted' => !$r->thread
            ];
        });

        $replyReports = \App\Models\ReplyReport::with(['reply', 'user'])->get()->map(function($r) {
            return (object)[
                'type' => 'reply',
                'id' => $r->id,
                'target_id' => $r->thread_reply_id,
                'pelapor' => $r->user,
                'konten' => $r->reply ? $r->reply->content : 'Balasan telah dihapus',
                'alasan' => $r->reason,
                'created_at' => $r->created_at,
                'is_deleted' => !$r->reply
            ];
        });

        $reports = $threadReports->concat($replyReports)->sortByDesc('created_at');

        return view('admin.laporan', compact('reports'));
    }

    /**
     * PBI 40: Eksekusi hapus postingan forum secara permanen.
     */
    public function hapusPostingan(Request $request, $id)
    {
        $type = $request->query('type', 'thread');
        
        if ($type === 'reply') {
            $reply = \App\Models\ThreadReply::findOrFail($id);
            $reply->delete();
            return back()->with('success', "Balasan telah dihapus secara permanen.");
        } else {
            $thread = \App\Models\Thread::findOrFail($id);
            $thread->delete();
            return back()->with('success', "Postingan telah dihapus secara permanen.");
        }
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