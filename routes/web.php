<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Route Resource untuk Jurnal Refleksi Mandiri
Route::resource('journals', JournalController::class);

Route::middleware('auth')->group(function () {
    Route::get('/settings', [UserController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [UserController::class, 'update'])->name('settings.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/faq', function () {
    return view('faq');
})->name('faq');
