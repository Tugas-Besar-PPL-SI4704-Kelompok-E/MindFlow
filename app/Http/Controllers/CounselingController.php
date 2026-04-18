<?php

namespace App\Http\Controllers;

use App\Models\ProfilKonselor;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function index(Request $request)
{
    $query = ProfilKonselor::query();

    // PBI 27: Filter berdasarkan spesialisasi
    if ($request->filled('spesialisasi')) {
        $query->where('spesialisasi', $request->spesialisasi);
    }

    $konselors = $query->get();
    return view('konseling.index', compact('konselors'));
}

public function show($id)
{
    // PBI 28: Menampilkan detail biografi & keahlian
    $konselor = ProfilKonselor::findOrFail($id);
    return view('konseling.show', compact('konselor'));
}
}