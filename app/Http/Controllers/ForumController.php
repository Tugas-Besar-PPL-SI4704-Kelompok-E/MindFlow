<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Komentar;
use App\Models\LaporanForum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * PBI-18: Menampilkan semua thread forum (timeline ala Twitter).
     */
    public function index()
    {
        $threads = Forum::with(['user', 'komentars'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('forum.index', compact('threads'));
    }

    /**
     * PBI-18: Form buat thread baru.
     */
    public function create()
    {
        return view('forum.create');
    }

    /**
     * PBI-18: Simpan thread baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_thread' => 'required|string|max:255',
            'konten' => 'required|string|min:3',
        ]);

        Forum::create([
            'user_id' => Auth::id(),
            'judul_thread' => $request->judul_thread,
            'konten' => $request->konten,
        ]);

        return redirect()->route('forum.index')
            ->with('success', 'Thread berhasil dibuat!');
    }

    /**
     * PBI-18: Menampilkan detail thread + komentar.
     */
    public function show($id)
    {
        $thread = Forum::with(['user', 'komentars.user'])->findOrFail($id);
        return view('forum.show', compact('thread'));
    }

    /**
     * PBI-18: Hapus thread sendiri.
     */
    public function destroy($id)
    {
        $thread = Forum::findOrFail($id);

        if ($thread->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus postingan ini.');
        }

        $thread->delete();

        return redirect()->route('forum.index')
            ->with('success', 'Postingan berhasil dihapus.');
    }

    /**
     * PBI-19: Tambah komentar ke thread.
     */
    public function storeKomentar(Request $request, $forumId)
    {
        $request->validate([
            'konten_komentar' => 'required|string|min:1',
        ]);

        Komentar::create([
            'forum_id' => $forumId,
            'user_id' => Auth::id(),
            'konten_komentar' => $request->konten_komentar,
        ]);

        return redirect()->route('forum.show', $forumId)
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * PBI-20: Report postingan forum.
     */
    public function report(Request $request, $forumId)
    {
        $request->validate([
            'alasan_laporan' => 'required|string|max:255',
        ]);

        LaporanForum::create([
            'forum_id' => $forumId,
            'pelapor_id' => Auth::id(),
            'alasan_laporan' => $request->alasan_laporan,
        ]);

        return redirect()->route('forum.show', $forumId)
            ->with('success', 'Laporan berhasil dikirim. Terima kasih atas laporanmu.');
    }
}
