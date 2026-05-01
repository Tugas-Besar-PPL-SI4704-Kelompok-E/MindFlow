<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ✅ Validasi input
        $request->validate([
            'nama_asli' => 'required|string|max:255',
            'nama_samaran' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // ✅ Update nama
        $user->nama_asli = $request->nama_asli;
        $user->nama_samaran = $request->nama_samaran;

        // ✅ Update password (kalau diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}