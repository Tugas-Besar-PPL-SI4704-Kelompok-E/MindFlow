<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\JournalController;

// PBI 27 & 28
Route::get('/konseling', [CounselingController::class, 'index'])->name('konseling.index');
Route::get('/konseling/{id}', [CounselingController::class, 'show'])->name('konseling.show');

// PBI 29 & 30
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// PBI 31
Route::put('/booking/update/{id}', [BookingController::class, 'updateJadwal'])->name('booking.update');

Route::get('/', function () {
    // Mengalihkan halaman utama (/) ke halaman konseling
    return redirect()->route('konseling.index');
});

// Route Resource untuk Jurnal Refleksi Mandiri
Route::resource('journals', JournalController::class);
