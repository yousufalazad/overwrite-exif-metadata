<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageOverwriteController;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::resource('image-overwrites', ImageOverwriteController::class);
    Route::get('/image-overwrites', [ImageOverwriteController::class, 'index'])->name('image-overwrites.index');
    Route::get('/image-overwrites/create', [ImageOverwriteController::class, 'create'])->name('image-overwrites.create');
    Route::post('/image-overwrites', [ImageOverwriteController::class, 'store'])->name('image-overwrites.store');
    Route::get('/image-overwrites/{imageOverwrite}', [ImageOverwriteController::class, 'show'])->name('image-overwrites.show');
    Route::get('/image-overwrites/{imageOverwrite}/edit', [ImageOverwriteController::class, 'edit'])->name('image-overwrites.edit');
    Route::put('/image-overwrites/{imageOverwrite}', [ImageOverwriteController::class, 'update'])->name('image-overwrites.update');
    Route::delete('/image-overwrites/{imageOverwrite}', [ImageOverwriteController::class, 'destroy'])->name('image-overwrites.destroy');
});

require __DIR__ . '/auth.php';
