<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HasilDass21;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_asli' => ['required', 'string', 'max:255'],
            'nama_samaran' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'nama_asli' => $request->nama_asli,
            'nama_samaran' => $request->nama_samaran,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role is user
        ]);

        Auth::login($user);

        // Check if guest has pending DASS-21 results from session
        if ($request->session()->has('guest_dass21_responses')) {
            $responses = $request->session()->get('guest_dass21_responses');
            $hasil = HasilDass21::hitungSkor($responses);

            HasilDass21::create([
                'user_id' => $user->id,
                'skor_depresi' => $hasil['skor_depresi'],
                'skor_kecemasan' => $hasil['skor_kecemasan'],
                'skor_stres' => $hasil['skor_stres'],
                'total_skor' => $hasil['total_skor'],
                'kategori_depresi' => $hasil['kategori_depresi'],
                'kategori_kecemasan' => $hasil['kategori_kecemasan'],
                'kategori_stres' => $hasil['kategori_stres'],
                'detail_jawaban' => $responses,
            ]);

            $request->session()->forget('guest_dass21_responses');

            return redirect('/mood-tracker')
                ->with('success', 'Akun berhasil dibuat! Berikut hasil pemeriksaan DASS-21 kamu.');
        }

        return redirect('/home');
    }
}
