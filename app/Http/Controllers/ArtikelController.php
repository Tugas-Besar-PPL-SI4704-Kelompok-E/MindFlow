<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    /**
     * Halaman listing artikel dengan search & filter.
     */
    public function index(Request $request)
    {
        $query = Artikel::query()->published()->with('admin')->withCount('bookmarks');

        // Search by judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        $artikels = $query->latest()->paginate(9)->withQueryString();

        // Daftar kategori untuk filter dropdown
        $kategoris = Artikel::published()
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        return view('artikel.index', compact('artikels', 'kategoris'));
    }

    /**
     * Halaman detail baca artikel.
     */
    public function show($id)
    {
        $artikel = Artikel::published()
            ->with('admin')
            ->withCount('bookmarks')
            ->findOrFail($id);

        // Artikel terkait (same kategori, exclude current)
        $artikelTerkait = Artikel::published()
            ->with('admin')
            ->where('artikel_id', '!=', $artikel->artikel_id)
            ->when($artikel->kategori, function ($query) use ($artikel) {
                $query->where('kategori', $artikel->kategori);
            })
            ->latest()
            ->take(3)
            ->get();

        return view('artikel.show', compact('artikel', 'artikelTerkait'));
    }

    /**
     * Halaman daftar artikel yang di-bookmark oleh user.
     */
    public function bookmarks(Request $request)
    {
        $query = Artikel::published()
            ->with('admin')
            ->withCount('bookmarks')
            ->whereHas('bookmarks', function ($q) {
                $q->where('user_id', Auth::id());
            });

        // Search by judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        $artikels = $query->latest()->paginate(9)->withQueryString();

        // Daftar kategori untuk filter dropdown
        $kategoris = Artikel::published()
            ->whereHas('bookmarks', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        return view('artikel.bookmarks', compact('artikels', 'kategoris'));
    }

    /**
     * Toggle bookmark artikel.
     */
    public function toggleBookmark($id)
    {
        $artikel = Artikel::published()->findOrFail($id);
        $user = Auth::user();

        if ($artikel->isBookmarkedBy($user->id)) {
            $artikel->bookmarks()->where('user_id', $user->id)->delete();
            $isBookmarked = false;
        } else {
            $artikel->bookmarks()->create(['user_id' => $user->id]);
            $isBookmarked = true;
        }

        return response()->json([
            'success' => true,
            'is_bookmarked' => $isBookmarked,
            'message' => $isBookmarked ? 'Artikel ditambahkan ke bookmark.' : 'Artikel dihapus dari bookmark.'
        ]);
    }

    /**
     * Laporkan artikel.
     */
    public function report(Request $request, $id)
    {
        $artikel = Artikel::published()->findOrFail($id);
        
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak diizinkan melaporkan artikel.');
        }

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        \App\Models\ArtikelReport::create([
            'artikel_id' => $artikel->artikel_id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Laporan artikel berhasil dikirim.');
    }
}
