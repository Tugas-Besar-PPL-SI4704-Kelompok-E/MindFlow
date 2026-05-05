<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfilKonselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CounselorRecruitmentController extends Controller
{
    /**
     * Menampilkan halaman form pendaftaran konselor.
     */
    public function create()
    {
        return view('auth.register-konselor');
    }

    /**
     * Memproses data pendaftaran konselor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nomor_whatsapp' => 'required|string|max:20',
            'no_sipp' => 'required|string|max:100',
            'spesialisasi' => 'required|string|max:255',
            'berkas_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'berkas_sipp' => 'required|file|mimes:pdf|max:2048',
            'berkas_cv' => 'required|file|mimes:pdf|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nomor_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'no_sipp.required' => 'Nomor SIPP/SIPK wajib diisi.',
            'spesialisasi.required' => 'Spesialisasi wajib dipilih.',
            'berkas_ktp.required' => 'Scan KTP wajib diunggah.',
            'berkas_ktp.max' => 'Ukuran file KTP maksimal 2MB.',
            'berkas_sipp.required' => 'File SIPP/Lisensi wajib diunggah.',
            'berkas_sipp.mimes' => 'File SIPP harus berformat PDF.',
            'berkas_sipp.max' => 'Ukuran file SIPP maksimal 2MB.',
            'berkas_cv.required' => 'CV wajib diunggah.',
            'berkas_cv.mimes' => 'CV harus berformat PDF.',
            'berkas_cv.max' => 'Ukuran file CV maksimal 2MB.',
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat akun user dengan role konselor & status pending
            $user = User::create([
                'nama_asli' => $request->nama_lengkap,
                'nama_samaran' => explode(' ', $request->nama_lengkap)[0],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'konselor',
                'status' => 'pending',
            ]);

            // 2. Upload berkas
            $berkasKtp = $request->file('berkas_ktp')->store('rekrutmen/ktp', 'public');
            $berkasSipp = $request->file('berkas_sipp')->store('rekrutmen/sipp', 'public');
            $berkasCv = $request->file('berkas_cv')->store('rekrutmen/cv', 'public');

            // 3. Buat profil konselor
            ProfilKonselor::create([
                'user_id' => $user->id,
                'nama' => $request->nama_lengkap,
                'spesialisasi' => $request->spesialisasi,
                'biografi' => '',
                'keahlian' => '',
                'nomor_whatsapp' => $request->nomor_whatsapp,
                'no_sipp' => $request->no_sipp,
                'berkas_ktp' => $berkasKtp,
                'berkas_sipp' => $berkasSipp,
                'berkas_cv' => $berkasCv,
            ]);

            DB::commit();

            return redirect()->route('rekrutmen.success');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pendaftaran. Silakan coba lagi.');
        }
    }

    /**
     * Halaman konfirmasi sukses setelah pendaftaran.
     */
    public function success()
    {
        return view('auth.register-konselor-success');
    }
}
