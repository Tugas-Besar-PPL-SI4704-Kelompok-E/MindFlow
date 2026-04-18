<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;

Route::get('/', function () {
    return view('welcome');
});

// Route Resource untuk Jurnal Refleksi Mandiri
// Middleware auth digunakan langsung di Controller (atau bisa juga ditambahkan di sini, tapi karena controller Anda sudah menggunakan $this->middleware('auth'), ini cukup)
Route::resource('journals', JournalController::class);
