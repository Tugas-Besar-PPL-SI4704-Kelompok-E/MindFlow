<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CounselorController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk konselor.
     */
    public function index()
    {
        return view('konselor.dashboard');
    }
}
