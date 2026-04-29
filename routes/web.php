<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AdminController;

// Grouping route admin agar tidak konflik
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/rekrutmen', [AdminController::class, 'rekrutmen'])->name('rekrutmen');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::delete('/forum/{id}/delete', [AdminController::class, 'hapusPostingan'])->name('forum.delete');
    Route::get('/spesialisasi', [AdminController::class, 'spesialisasi'])->name('spesialisasi');
});
// Route Resource untuk Jurnal Refleksi Mandiri
// Middleware auth digunakan langsung di Controller (atau bisa juga ditambahkan di sini, tapi karena controller Anda sudah menggunakan $this->middleware('auth'), ini cukup)
Route::resource('journals', JournalController::class);
