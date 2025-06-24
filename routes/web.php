<?php

use App\Http\Controllers\SpeechController;
use App\Models\Speech;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard route
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('speeches', [SpeechController::class, 'index'])->name('speeches.index')->can('viewAny', Speech::class);
    Route::get('speeches/create', [SpeechController::class, 'create'])->name('speeches.create')->can('create', Speech::class);
    Route::post('speeches', [SpeechController::class, 'store'])->name('speeches.store')->can('create', Speech::class);
    Route::get('speeches/{speech}', [SpeechController::class, 'show'])->name('speeches.show')->can('view', 'speech');
    Route::get('speeches/{speech}/edit', [SpeechController::class, 'edit'])->name('speeches.edit')->can('update', 'speech');
    Route::put('speeches/{speech}', [SpeechController::class, 'update'])->name('speeches.update')->can('update', 'speech');
    Route::delete('speeches/{speech}', [SpeechController::class, 'destroy'])->name('speeches.destroy')->can('delete', 'speech');

});

Route::get('auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('auth/callback', function () {
    $user = Socialite::driver('google')->user();

    // $user->token
});
