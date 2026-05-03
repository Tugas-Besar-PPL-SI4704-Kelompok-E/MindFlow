<?php

use App\Http\Controllers\MoodTrackerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\ThreadInteractionController;

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
    return view('faq');
})->name('faq');

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

    // PBI 31
    Route::put('/booking/update/{id}', [BookingController::class, 'updateJadwal'])->name('booking.update');

    // Mood Tracker Routes (Other than mendalam)
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

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/rekrutmen', [AdminController::class, 'rekrutmen'])->name('rekrutmen');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::delete('/forum/{id}/delete', [AdminController::class, 'hapusPostingan'])->name('forum.delete');
        Route::get('/spesialisasi', [AdminController::class, 'spesialisasi'])->name('spesialisasi');
    });

    // Konselor Routes
    Route::prefix('konselor')->name('konselor.')->group(function () {
        Route::get('/dashboard', [CounselorController::class, 'index'])->name('dashboard');
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
    
    // Settings
    Route::get('/settings', [UserController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [UserController::class, 'update'])->name('settings.update');
});
