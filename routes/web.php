<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
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

// Endpoint simple de salud para Railway
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'app' => 'gestor-tareas'
    ]);
});

// Debug route - no dependencies
Route::get('/debug', function () {
    return response('Laravel is working! PHP ' . PHP_VERSION, 200)
        ->header('Content-Type', 'text/plain');
});

// Test database connection
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return response('Database connection OK', 200)
            ->header('Content-Type', 'text/plain');
    } catch (\Exception $e) {
        return response('Database error: ' . $e->getMessage(), 500)
            ->header('Content-Type', 'text/plain');
    }
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
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
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

require __DIR__.'/auth.php';
