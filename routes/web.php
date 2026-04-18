<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CounselingController;

// PBI 27 & 28
Route::get('/konseling', [CounselingController::class, 'index'])->name('konseling.index');
Route::get('/konseling/{id}', [CounselingController::class, 'show'])->name('konseling.show');

// PBI 29 & 30
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// PBI 31
Route::put('/booking/update/{id}', [BookingController::class, 'updateJadwal'])->name('booking.update');
