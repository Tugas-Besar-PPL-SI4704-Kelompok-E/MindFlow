<?php

use App\Http\Controllers\MoodTrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\CounselorRecruitmentController;
use App\Http\Controllers\ThreadInteractionController;
use App\Http\Controllers\ArtikelController;

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

// ──────────────────── Public Routes ────────────────────
// PBI-5: Pemeriksaan mendalam — accessible by GUEST (no auth needed)
Route::get('/mood-tracker/mendalam', [MoodTrackerController::class, 'mendalam'])
    ->name('mood-tracker.mendalam');
Route::post('/mood-tracker/mendalam', [MoodTrackerController::class, 'mendalamStore'])
    ->name('mood-tracker.mendalam.store');

Route::get('/faq', function () {
    if (auth()->check()) {
        return redirect()->route('settings.edit', [], 302)->withFragment('faq');
    }
    return view('faq');
})->name('faq');

// ──────────────────── Rekrutmen Konselor (Public) ────────────────────
Route::get('/rekrutmen-konselor', [CounselorRecruitmentController::class, 'create'])->name('rekrutmen.create');
Route::post('/rekrutmen-konselor', [CounselorRecruitmentController::class, 'store'])->name('rekrutmen.store');
Route::get('/rekrutmen-konselor/sukses', [CounselorRecruitmentController::class, 'success'])->name('rekrutmen.success');

// ──────────────────── Protected Routes (Requires Login) ────────────────────
Route::middleware('auth')->group(function () {
    
    // Homepage (after login)
    Route::get('/home', function () {
        return view('homepage');
    })->name('homepage');

    // Konseling Routes (PBI 27 & 28)
    Route::get('/konseling', [CounselingController::class, 'index'])->name('konseling.index');
    Route::get('/konseling/{id}', [CounselingController::class, 'show'])->name('konseling.show');

    // PBI 29 & 30
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/check-expired', [BookingController::class, 'checkExpiredPending'])->name('booking.checkExpired');

    // PBI 31
    Route::get('/booking/edit/{id}', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/update/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/cancel/{id}', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::post('/booking/clear-expired-notification', [BookingController::class, 'clearExpiredNotification'])->name('booking.clear-expired-notification');

    // History Route
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // Mood Tracker Routes (Other than mendalam)
    Route::get('/mood-tracker', [MoodTrackerController::class, 'index'])
        ->name('mood-tracker.index');
    Route::get('/mood-tracker/mendalam/hasil/{id}', [MoodTrackerController::class, 'mendalamHasil'])
        ->name('mood-tracker.mendalam.hasil');
    Route::get('/mood-tracker/singkat', [MoodTrackerController::class, 'singkat'])
        ->name('mood-tracker.singkat');
    Route::post('/mood-tracker/singkat', [MoodTrackerController::class, 'singkatStore'])
        ->name('mood-tracker.singkat.store');
    Route::get('/mood-tracker/open-question', [MoodTrackerController::class, 'openQuestion'])
        ->name('mood-tracker.open-question');
    Route::post('/mood-tracker/open-question', [MoodTrackerController::class, 'openQuestionStore'])
        ->name('mood-tracker.open-question.store');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/rekrutmen', [AdminController::class, 'rekrutmen'])->name('rekrutmen');
        Route::post('/rekrutmen/{id}/approve', [AdminController::class, 'approveKonselor'])->name('rekrutmen.approve');
        Route::post('/rekrutmen/{id}/reject', [AdminController::class, 'rejectKonselor'])->name('rekrutmen.reject');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::post('/laporan/{id}/punish', [AdminController::class, 'punishUser'])->name('laporan.punish');
        Route::delete('/forum/{id}/delete', [AdminController::class, 'hapusPostingan'])->name('forum.delete');
        Route::get('/spesialisasi', [AdminController::class, 'spesialisasi'])->name('spesialisasi');
        Route::post('/spesialisasi', [AdminController::class, 'storeSpesialisasi'])->name('spesialisasi.store');
        Route::put('/spesialisasi/{id}', [AdminController::class, 'updateSpesialisasi'])->name('spesialisasi.update');
        Route::post('/spesialisasi/{id}/toggle', [AdminController::class, 'toggleSpesialisasi'])->name('spesialisasi.toggle');
        Route::delete('/spesialisasi/{id}', [AdminController::class, 'destroySpesialisasi'])->name('spesialisasi.destroy');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        // Konseling admin actions
        Route::post('/konseling/{id}/confirm', [\App\Http\Controllers\AdminKonselingController::class, 'confirm'])->name('konseling.confirm');
        Route::post('/konseling/{id}/cancel', [\App\Http\Controllers\AdminKonselingController::class, 'cancel'])->name('konseling.cancel');
    });

    // Konselor Routes
    Route::prefix('konselor')->name('konselor.')->middleware('role:konselor')->group(function () {
        Route::get('/dashboard', [CounselorController::class, 'index'])->name('dashboard');
        Route::get('/jadwal', [CounselorController::class, 'jadwal'])->name('jadwal');
        Route::get('/pasien', [CounselorController::class, 'pasien'])->name('pasien');
        Route::post('/jadwal/{id}/accept', [CounselorController::class, 'acceptSession'])->name('jadwal.accept');
        Route::post('/jadwal/{id}/reject', [CounselorController::class, 'rejectSession'])->name('jadwal.reject');
        Route::post('/jadwal/{id}/evaluasi', [CounselorController::class, 'submitEvaluasi'])->name('jadwal.evaluasi');
        
        // PBI 34: Ketersediaan Jadwal
        Route::resource('/counselor-schedules', \App\Http\Controllers\CounselorScheduleController::class)
            ->names('counselor-schedules')
            ->except(['show', 'create', 'edit']);
            
        Route::get('/settings', [CounselorController::class, 'settings'])->name('settings');
        Route::put('/settings', [CounselorController::class, 'updateSettings'])->name('settings.update');
    });

    // Journal Routes (PBI 15, 16, 17)
    Route::resource('journals', JournalController::class);

    // Forum resource routes
    Route::resource('forum', ForumController::class);

    Route::post('forum/{thread}/like', [ThreadInteractionController::class, 'toggleLike'])->name('forum.like');
    Route::post('forum/{thread}/save', [ThreadInteractionController::class, 'toggleSave'])->name('forum.save');
    Route::post('forum/{thread}/reply', [ThreadInteractionController::class, 'storeReply'])->name('forum.reply');
    Route::post('forum/{thread}/report', [ThreadInteractionController::class, 'reportThread'])->name('forum.report');
    Route::post('forum/reply/{reply}/report', [ThreadInteractionController::class, 'reportReply'])->name('forum.reply.report');
    Route::delete('forum/reply/{reply}', [ThreadInteractionController::class, 'destroyReply'])->name('forum.reply.destroy');

    // ──────────────────── Artikel Routes ────────────────────
    Route::prefix('artikel')->name('artikel.')->group(function () {
        Route::get('/', [ArtikelController::class, 'index'])->name('index');
    });
    
    // Settings
    Route::get('/settings', [UserController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [UserController::class, 'update'])->name('settings.update');
});
