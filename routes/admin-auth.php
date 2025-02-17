<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('admin')->name('admin.')->group(function () {
    Volt::route('register', 'admin.pages.auth.register')
        ->name('register');

    Volt::route('login', 'admin.pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'admin.pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'admin.pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware(['auth:admin','is_admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::view('/', 'livewire.admin.dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    Route::view('profile', 'livewire.admin.profile')
        ->name('profile');

    Volt::route('verify-email', 'admin.pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'admin.pages.auth.confirm-password')
        ->name('password.confirm');
});
