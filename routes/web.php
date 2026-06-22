<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Admin routes (temporairement sans auth pour le développement front)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    Route::get('/utilisateurs', function () {
        return Inertia::render('Admin/Utilisateurs');
    })->name('admin.utilisateurs');

    Route::get('/transitaires', function () {
        return Inertia::render('Admin/Dashboard'); // placeholder
    })->name('admin.transitaires');

    Route::get('/stockage', function () {
        return Inertia::render('Admin/Dashboard'); // placeholder
    })->name('admin.stockage');

    Route::get('/parametres', function () {
        return Inertia::render('Admin/Parametres');
    })->name('admin.parametres');

    Route::get('/regularisation', function () {
        return Inertia::render('Admin/Dashboard'); // placeholder
    })->name('admin.regularisation');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/test', function() { return 'TEST OK'; });
