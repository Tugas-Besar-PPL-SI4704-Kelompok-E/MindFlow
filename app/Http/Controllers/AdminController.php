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
        $threadReports = \App\Models\ThreadReport::with(['thread' => function($q) { $q->withTrashed(); }, 'thread.user', 'user'])
            ->get()
            ->filter(function($r) {
                $isTrashed = $r->thread && $r->thread->trashed();
                $isMuted = $r->thread && $r->thread->user && $r->thread->user->status === 'muted' && \Carbon\Carbon::parse($r->thread->user->muted_until)->isFuture();
                
                // Hapus laporan dan postingan dari DB secara PERMANEN jika postingan sudah di-soft-delete dan user tidak di-mute
                if ($isTrashed && !$isMuted) {
                    if ($r->thread) {
                        $r->thread->forceDelete(); // Ini akan memicu cascade delete pada laporan
                    } else {
                        $r->delete();
                    }
                    return false;
                }
                return true;
            })
            ->map(function($r) {
                return (object)[
                    'type' => 'thread',
                    'id' => $r->id,
                    'target_id' => $r->thread_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->thread ? $r->thread->user : null,
                    'konten' => $r->thread ? $r->thread->content : 'Postingan telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                    'is_deleted' => $r->thread ? $r->thread->trashed() : true
                ];
            });

        $replyReports = \App\Models\ReplyReport::with(['reply' => function($q) { $q->withTrashed(); }, 'reply.user', 'user'])
            ->get()
            ->filter(function($r) {
                $isTrashed = $r->reply && $r->reply->trashed();
                $isMuted = $r->reply && $r->reply->user && $r->reply->user->status === 'muted' && \Carbon\Carbon::parse($r->reply->user->muted_until)->isFuture();
                
                if ($isTrashed && !$isMuted) {
                    if ($r->reply) {
                        $r->reply->forceDelete();
                    } else {
                        $r->delete();
                    }
                    return false;
                }
                return true;
            })
            ->map(function($r) {
                return (object)[
                    'type' => 'reply',
                    'id' => $r->id,
                    'target_id' => $r->thread_reply_id,
                    'pelapor' => $r->user,
                    'pelanggar' => $r->reply ? $r->reply->user : null,
                    'konten' => $r->reply ? $r->reply->content : 'Balasan telah dihapus',
                    'alasan' => $r->reason,
                    'created_at' => $r->created_at,
                    'is_deleted' => $r->reply ? $r->reply->trashed() : true
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
     * PBI 41: Menjatuhkan hukuman kepada pengguna.
     */
    public function punishUser(Request $request, $id)
    {
        $request->validate([
            'punishment_type' => 'required|in:mute',
            'duration' => 'required|integer|min:1',
            'reason' => 'required|string|max:1000'
        ]);

        $user = \App\Models\User::findOrFail($id);
        
        if ($request->punishment_type === 'mute') {
            $user->update([
                'status' => 'muted',
                'muted_until' => now()->addHours((int) $request->duration),
                'punishment_reason' => $request->reason
            ]);
        }

        return back()->with('success', 'Hukuman berhasil dijatuhkan kepada pengguna');
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
     * PBI 39: Pengelolaan kategori spesialisasi konselor — tampilkan data dari database.
     */
    public function spesialisasi()
    {
        $spesialisasis = \App\Models\Spesialisasi::orderBy('nama')->get();

        return view('admin.spesialisasi', compact('spesialisasis'));
    }

    /**
     * PBI 39: Tambah spesialisasi baru.
     */
    public function storeSpesialisasi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:spesialisasis,nama',
        ]);

        \App\Models\Spesialisasi::create(['nama' => $request->nama]);

        return back()->with('success', 'Spesialisasi "' . $request->nama . '" berhasil ditambahkan!');
    }

    /**
     * PBI 39: Update nama spesialisasi.
     */
    public function updateSpesialisasi(Request $request, $id)
    {
        $spesialisasi = \App\Models\Spesialisasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100|unique:spesialisasis,nama,' . $id,
        ]);

        $spesialisasi->update(['nama' => $request->nama]);

        return back()->with('success', 'Spesialisasi berhasil diperbarui!');
    }

    /**
     * PBI 39: Toggle status aktif/nonaktif spesialisasi.
     */
    public function toggleSpesialisasi($id)
    {
        $spesialisasi = \App\Models\Spesialisasi::findOrFail($id);
        $spesialisasi->update(['is_active' => !$spesialisasi->is_active]);

        $status = $spesialisasi->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', 'Spesialisasi "' . $spesialisasi->nama . '" berhasil ' . $status . '!');
    }

    /**
     * PBI 39: Hapus spesialisasi.
     */
    public function destroySpesialisasi($id)
    {
        $spesialisasi = \App\Models\Spesialisasi::findOrFail($id);
        $nama = $spesialisasi->nama;
        $spesialisasi->delete();

        return back()->with('success', 'Spesialisasi "' . $nama . '" berhasil dihapus!');
    }
}