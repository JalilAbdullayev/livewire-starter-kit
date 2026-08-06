<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/site.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
