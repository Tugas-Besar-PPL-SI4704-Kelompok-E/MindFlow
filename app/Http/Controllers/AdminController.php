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
        $totalUsers      = User::where('role', 'user')->count();
        $totalKonselor   = User::where('role', 'konselor')->count();
        $totalReports    = \App\Models\ThreadReport::count() + \App\Models\ReplyReport::count();
        $totalThreads    = \App\Models\Thread::count();
        $totalSessions   = \App\Models\SesiKonseling::count();
        $totalJournals   = \App\Models\Journal::count();

        // Pengguna baru per hari (7 hari terakhir)
        $userGrowth = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $userGrowth[] = [
                'label' => $date->translatedFormat('D'),
                'count' => User::whereDate('created_at', $date->toDateString())->count(),
            ];
        }

        // Aktivitas terbaru (gabungan thread & sesi terbaru)
        $recentThreads = \App\Models\Thread::with('user')->latest()->take(5)->get();
        $recentReports = \App\Models\ThreadReport::with(['thread', 'user'])->latest()->take(5)->get();

        $data = compact(
            'totalUsers', 'totalKonselor', 'totalReports',
            'totalThreads', 'totalSessions', 'totalJournals',
            'userGrowth', 'recentThreads', 'recentReports'
        );

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
     * PBI 37: Page rekrutmen aplikan — data real dari database.
     */
    public function rekrutmen()
    {
        // Ambil semua user konselor beserta profil mereka
        $applicants = User::where('role', 'konselor')
            ->with('profilKonselor')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest()
            ->get();

        return view('admin.rekrutmen', compact('applicants'));
    }

    /**
     * Approve aplikan konselor — ubah status menjadi approved.
     */
    public function approveKonselor($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        return back()->with('success', 'Konselor ' . $user->nama_asli . ' berhasil diverifikasi!');
    }

    /**
     * Reject aplikan konselor — ubah status menjadi rejected.
     */
    public function rejectKonselor($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', 'Aplikan ' . $user->nama_asli . ' telah ditolak.');
    }

    /**
     * PBI 39: Pengelolaan kategori spesialisasi konselor.
     */
    public function spesialisasi()
    {
        return view('admin.spesialisasi');
    }
}