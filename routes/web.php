<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Nuevas rutas para vistas separadas de perfil
    Route::get('/profile/info', function () {
        return Inertia::render('Profile/EditInfo', [
            'mustVerifyEmail' => request()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
            'status' => session('status'),
        ]);
    })->name('profile.edit.info');

    Route::get('/profile/password', function () {
        return Inertia::render('Profile/EditPassword');
    })->name('profile.edit.password');

    Route::get('/profile/delete', function () {
        return Inertia::render('Profile/EditDelete');
    })->name('profile.edit.delete');

    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';
