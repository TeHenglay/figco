<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Chat
    Route::get('/chat',                          [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat',                         [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{conversation}',           [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/message',  [ChatController::class, 'sendMessage'])->name('chat.message');
    Route::delete('/chat/{conversation}',        [ChatController::class, 'destroy'])->name('chat.destroy');

    // Homework
    Route::get('/homework',                      [HomeworkController::class, 'index'])->name('homework.index');
    Route::get('/homework/create',               [HomeworkController::class, 'create'])->name('homework.create');
    Route::post('/homework',                     [HomeworkController::class, 'store'])->name('homework.store');
    Route::get('/homework/{homework}',           [HomeworkController::class, 'show'])->name('homework.show');
    Route::get('/homework/{homework}/status',    [HomeworkController::class, 'status'])->name('homework.status');
    Route::post('/homework/{homework}/timeout',  [HomeworkController::class, 'timeout'])->name('homework.timeout');
    Route::get('/homework/{homework}/download/{format}', [HomeworkController::class, 'download'])->name('homework.download');
    Route::delete('/homework/{homework}',        [HomeworkController::class, 'destroy'])->name('homework.destroy');

    // Profile
    Route::get('/api-keys',   [ProfileController::class, 'apiKeys'])->name('api-keys');
    Route::post('/api-keys',  [ProfileController::class, 'updateApiKeys'])->name('api-keys.update');
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// n8n webhook callbacks (no auth — secured by callback_secret)
Route::post('/webhook/n8n/homework', [WebhookController::class, 'homeworkCallback'])->name('webhook.n8n.homework');

require __DIR__.'/auth.php';
