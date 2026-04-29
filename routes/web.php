<?php

use App\Http\Controllers\MoodTrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

// ──────────────────── Mood Tracker Routes ────────────────────
Route::get('/mood-tracker', [MoodTrackerController::class, 'index'])
    ->name('mood-tracker.index');

Route::get('/mood-tracker/singkat', [MoodTrackerController::class, 'singkat'])
    ->name('mood-tracker.singkat');

Route::post('/mood-tracker/singkat', [MoodTrackerController::class, 'singkatStore'])
    ->name('mood-tracker.singkat.store');

Route::get('/mood-tracker/open-question', [MoodTrackerController::class, 'openQuestion'])
    ->name('mood-tracker.open-question');

Route::post('/mood-tracker/open-question', [MoodTrackerController::class, 'openQuestionStore'])
    ->name('mood-tracker.open-question.store');

Route::get('/mood-tracker/mendalam', [MoodTrackerController::class, 'mendalam'])
    ->name('mood-tracker.mendalam');

Route::post('/mood-tracker/mendalam', [MoodTrackerController::class, 'mendalamStore'])
    ->name('mood-tracker.mendalam.store');
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
Route::resource('journals', JournalController::class);
