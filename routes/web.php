<?php

use App\Http\Controllers\MoodTrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;

// ──────────────────── Landing Page (Guest) ────────────────────
Route::get('/', function () {
    return view('landing');
})->name('home');

// ──────────────────── Auth Routes ────────────────────
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ──────────────────── Homepage (after login) ────────────────────
Route::get('/home', function () {
    return view('homepage');
})->name('homepage');

// ──────────────────── Konseling Routes (PBI 27 & 28) ────────────────────
Route::get('/konseling', [CounselingController::class, 'index'])->name('konseling.index');
Route::get('/konseling/{id}', [CounselingController::class, 'show'])->name('konseling.show');

// PBI 29 & 30
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// PBI 31
Route::put('/booking/update/{id}', [BookingController::class, 'updateJadwal'])->name('booking.update');

// ──────────────────── Mood Tracker Routes ────────────────────
// PBI-5: Pemeriksaan mendalam — accessible by GUEST (no auth needed)
Route::get('/mood-tracker/mendalam', [MoodTrackerController::class, 'mendalam'])
    ->name('mood-tracker.mendalam');
Route::post('/mood-tracker/mendalam', [MoodTrackerController::class, 'mendalamStore'])
    ->name('mood-tracker.mendalam.store');

// Other mood tracker routes (require login)
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

// ──────────────────── Forum Routes (PBI 18, 19, 20) ────────────────────
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');
Route::post('/forum/{id}/komentar', [ForumController::class, 'storeKomentar'])->name('forum.komentar');
Route::post('/forum/{id}/report', [ForumController::class, 'report'])->name('forum.report');

// ──────────────────── Admin Routes ────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/rekrutmen', [AdminController::class, 'rekrutmen'])->name('rekrutmen');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::delete('/forum/{id}/delete', [AdminController::class, 'hapusPostingan'])->name('forum.delete');
    Route::get('/spesialisasi', [AdminController::class, 'spesialisasi'])->name('spesialisasi');
});

// ──────────────────── Journal Routes (PBI 15, 16, 17) ────────────────────
Route::resource('journals', JournalController::class);
