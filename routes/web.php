<?php

use App\Http\Controllers\ComponentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('projects.index') : view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/component-library', [ComponentController::class, 'library'])->name('component-library');
    Route::get('/api-keys', [ProfileController::class, 'apiKeys'])->name('api-keys');
    Route::post('/api-keys', [ProfileController::class, 'updateApiKeys'])->name('api-keys.update');

    Route::resource('projects', ProjectController::class)->except(['edit', 'update']);
    Route::get('/projects/{project}/components/create', [ComponentController::class, 'create'])->name('components.create');
    Route::post('/projects/{project}/components', [ComponentController::class, 'store'])->name('components.store');
    Route::get('/components/{component}', [ComponentController::class, 'show'])->name('components.show');
    Route::get('/components/{component}/status', [ComponentController::class, 'status'])->name('components.status');
    Route::delete('/components/{component}', [ComponentController::class, 'destroy'])->name('components.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/webhook/n8n', [WebhookController::class, 'n8n'])->name('webhook.n8n');

require __DIR__.'/auth.php';
