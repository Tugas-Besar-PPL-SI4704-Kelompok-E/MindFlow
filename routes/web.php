<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;

Route::get('/', function () {
    return view('welcome');
});

// Forum resource routes
Route::resource('forum', ForumController::class);

use App\Http\Controllers\ThreadInteractionController;
Route::post('forum/{thread}/like', [ThreadInteractionController::class, 'toggleLike'])->name('forum.like');
Route::post('forum/{thread}/save', [ThreadInteractionController::class, 'toggleSave'])->name('forum.save');
Route::post('forum/{thread}/reply', [ThreadInteractionController::class, 'storeReply'])->name('forum.reply');
Route::post('forum/{thread}/report', [ThreadInteractionController::class, 'reportThread'])->name('forum.report');
Route::post('forum/reply/{reply}/report', [ThreadInteractionController::class, 'reportReply'])->name('forum.reply.report');
