<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // PBI 42: Bar metrik dashboard menggunakan Dummy Data
    public function index()
    {
        $data = [
            'totalUsers' => 1240,       // Angka dummy
            'totalArticles' => 86,      // Angka dummy
            'totalApplicants' => 12,    // Angka dummy
            'totalReports' => 5,        // Angka dummy
        ];

        return view('admin.dashboard', $data);
    }

    // PBI 38 & 40: Laporan pelanggaran menggunakan Dummy Data
    public function laporan()
    {
        // Membuat data palsu (dummy) yang strukturnya mirip dengan hasil database (Eloquent)
        $reports = collect([
            (object)[
                'id' => 1,
                'user' => (object)['name' => 'Budi Santoso'],
                'forum' => (object)[
                    'id' => 101, 
                    'konten' => 'Dasar kalian semua orang gila, mending mati aja sana!'
                ],
                'alasan' => 'Ujaran Kebencian & Pelecehan',
                'created_at' => Carbon::now()->subDays(2)
            ],
            (object)[
                'id' => 2,
                'user' => (object)['name' => 'Siti Aminah'],
                'forum' => (object)[
                    'id' => 102, 
                    'konten' => 'Klik link ini untuk menang slot gacor terpercaya http://judi-online-fake.com'
                ],
                'alasan' => 'Spam / Promosi Ilegal',
                'created_at' => Carbon::now()->subHours(5)
            ]
        ]);

        return view('admin.laporan', compact('reports'));
    }

    // PBI 40: Eksekusi hapus (Simulasi)
    public function hapusPostingan($id)
    {
        // Karena kita tidak pakai database, kita buat simulasi berhasil saja
        // Nantinya kode ini tinggal diganti dengan: Forum::findOrFail($id)->delete();
        
        return back()->with('success', "Simulasi: Postingan dengan ID Forum ($id) seolah-olah telah dihapus secara permanen dari sistem.");
    }

    // PBI 37: Page rekrutmen aplikan menggunakan Dummy Data
    public function rekrutmen()
    {
        $applicants = collect([
            (object)[
                'id' => 1,
                'nama' => 'Dr. Aisyah Putri',
                'email' => 'aisyah.putri@klinikjiwa.com',
                'spesialisasi' => 'Klinis & Depresi',
                'tanggal_daftar' => '18 Apr 2026',
                'status' => 'Menunggu Review'
            ],
            (object)[
                'id' => 2,
                'nama' => 'Bima Satria, M.Psi',
                'email' => 'bimasatria@gmail.com',
                'spesialisasi' => 'Konseling Remaja',
                'tanggal_daftar' => '19 Apr 2026',
                'status' => 'Menunggu Review'
            ]
        ]);

        return view('admin.rekrutmen', compact('applicants'));
    }

    public function spesialisasi()
    {
        return view('admin.spesialisasi'); // Pastikan kamu membuat file ini nanti
    }
}