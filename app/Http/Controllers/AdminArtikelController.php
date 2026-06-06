<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Artikel::query()->with('admin');

        // Search by judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $artikels = $query->latest()->paginate(10)->withQueryString();

        // Distinct categories for filter
        $kategoris = Artikel::whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->sort()
            ->values();

        return view('admin.artikel.index', compact('artikels', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availableKategoris = ['Kesehatan Mental', 'Tips & Trik', 'Motivasi', 'Edukasi'];
        $defaultPenerbit = Auth::user()->nama_asli ?? 'Admin MindFlow';
        
        return view('admin.artikel.create', compact('availableKategoris', 'defaultPenerbit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'kategori_baru' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'created_at' => 'nullable|date',
        ]);

        $kategori = $request->kategori_baru ?: $request->kategori;

        $data = [
            'admin_id' => Auth::id(),
            'judul' => $request->judul,
            'konten' => $request->konten,
            'kategori' => $kategori,
            'penerbit' => $request->penerbit ?: (Auth::user()->nama_asli ?? 'Admin MindFlow'),
            'status' => $request->status,
        ];

        if ($request->hasFile('gambar_cover')) {
            $data['gambar_cover'] = $request->file('gambar_cover')->store('artikel/cover', 'public');
        }

        $artikel = new Artikel($data);

        // Override created_at if provided
        if ($request->filled('created_at')) {
            $artikel->created_at = Carbon::parse($request->created_at);
        }

        $artikel->save();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        $availableKategoris = ['Kesehatan Mental', 'Tips & Trik', 'Motivasi', 'Edukasi'];
        
        return view('admin.artikel.edit', compact('artikel', 'availableKategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'kategori_baru' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'created_at' => 'nullable|date',
        ]);

        $kategori = $request->kategori_baru ?: $request->kategori;

        $artikel->judul = $request->judul;
        $artikel->konten = $request->konten;
        $artikel->kategori = $kategori;
        $artikel->penerbit = $request->penerbit ?: (Auth::user()->nama_asli ?? 'Admin MindFlow');
        $artikel->status = $request->status;

        if ($request->hasFile('gambar_cover')) {
            // Delete old cover if exists
            if ($artikel->gambar_cover) {
                Storage::disk('public')->delete($artikel->gambar_cover);
            }
            $artikel->gambar_cover = $request->file('gambar_cover')->store('artikel/cover', 'public');
        }

        if ($request->filled('created_at')) {
            $artikel->created_at = Carbon::parse($request->created_at);
        }

        $artikel->save();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        if ($artikel->gambar_cover) {
            Storage::disk('public')->delete($artikel->gambar_cover);
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
