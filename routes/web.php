<?php

use App\Http\Controllers\MoodTrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
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
