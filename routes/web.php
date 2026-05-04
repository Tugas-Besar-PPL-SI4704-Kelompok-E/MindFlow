<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CounselingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ThreadInteractionController;

Route::get('/', function () {
    return view('welcome');
});

// Route Resource untuk Jurnal Refleksi Mandiri
// Middleware auth digunakan langsung di Controller (atau bisa juga ditambahkan di sini, tapi karena controller Anda sudah menggunakan $this->middleware('auth'), ini cukup)
Route::resource('journals', JournalController::class);

// ──────────────────── History Route ────────────────────
Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

// Forum resource routes
// (Asumsi ForumController & UserController sudah di-import di atasnya atau berfungsi normal)
Route::resource('forum', ForumController::class);

Route::post('forum/{thread}/like', [ThreadInteractionController::class, 'toggleLike'])->name('forum.like');
Route::post('forum/{thread}/save', [ThreadInteractionController::class, 'toggleSave'])->name('forum.save');
Route::post('forum/{thread}/reply', [ThreadInteractionController::class, 'storeReply'])->name('forum.reply');
Route::post('forum/{thread}/report', [ThreadInteractionController::class, 'reportThread'])->name('forum.report');
Route::post('forum/reply/{reply}/report', [ThreadInteractionController::class, 'reportReply'])->name('forum.reply.report');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [UserController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [UserController::class, 'update'])->name('settings.update');
});

Route::get('/faq', function () {
    return view('faq');
})->name('faq');