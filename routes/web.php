<?php

use App\Http\Controllers\SpeechController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkshopController;
use App\Models\Speech;
use App\Models\User;
use App\Models\Workshop;
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

    // Workshop
    Route::get('workshops', [WorkshopController::class, 'index'])->name('workshops.index')->can('viewAny', Workshop::class);
    Route::get('workshops/create', [WorkshopController::class, 'create'])->name('workshops.create')->can('create', Workshop::class);
    Route::post('workshops', [WorkshopController::class, 'store'])->name('workshops.store')->can('create', Workshop::class);
    Route::get('workshops/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show')->can('view', 'workshop');
    Route::get('workshops/{workshop}/edit', [WorkshopController::class, 'edit'])->name('workshops.edit')->can('update', 'workshop');
    Route::put('workshops/{workshop}', [WorkshopController::class, 'update'])->name('workshops.update')->can('update', 'workshop');
    Route::delete('workshops/{workshop}', [WorkshopController::class, 'destroy'])->name('workshops.destroy')->can('delete', 'workshop');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->can('create', User::class);
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show')->can('view', 'user');
    Route::post('users', [UserController::class, 'store'])->name('users.store')->can('create', User::class);
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->can('delete', 'user');
    Route::get('users', [UserController::class, 'index'])->name('users.index')->can('viewAny', User::class);

});

Route::get('auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('auth/callback', function () {
    $user = Socialite::driver('google')->user();

    // $user->token
});
