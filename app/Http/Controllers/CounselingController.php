<?php

namespace App\Http\Controllers;

use App\Models\ProfilKonselor;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    public function index(Request $request)
    {
        $query = ProfilKonselor::with('user');

        if ($request->has('spesialisasi') && $request->spesialisasi != '') {
            $query->where('spesialisasi', 'like', '%' . $request->spesialisasi . '%');
        }

        $konselors = $query->get();
        return view('konseling.index', compact('konselors'));
    }

    public function show($id)
    {
        $konselor = ProfilKonselor::with('user')->findOrFail($id);
        return view('konseling.show', compact('konselor'));
    }
}