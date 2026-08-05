<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::site.home')->name('home');

require __DIR__.'/site.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
