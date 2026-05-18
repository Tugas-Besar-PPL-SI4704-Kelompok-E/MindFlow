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
}
