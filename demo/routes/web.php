<?php

use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActivityLogController::class, 'index'])->name('logs.index');
Route::get('/manual-log', [ActivityLogController::class, 'manualLog'])->name('logs.manual');
Route::get('/create-post', [ActivityLogController::class, 'createPost'])->name('logs.create-post');
Route::get('/update-post', [ActivityLogController::class, 'updatePost'])->name('logs.update-post');
Route::get('/delete-post', [ActivityLogController::class, 'deletePost'])->name('logs.delete-post');
Route::get('/clear-logs', [ActivityLogController::class, 'clearLogs'])->name('logs.clear');
