<?php

use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/index', function () {
    return view('livewire.admin.index1');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
