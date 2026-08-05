<?php

use Illuminate\Support\Facades\Route;

Route::middleware('module:about')->group(function () {
    Route::livewire('/about', 'pages::site.about')->name('site.about');
});

Route::middleware('module:contact')->group(function () {
    Route::livewire('/contact', 'pages::site.contact')->name('site.contact');
});

Route::middleware('module:blog')->group(function () {
    Route::livewire('/blog', 'pages::site.blog.index')->name('site.blog.index');
    Route::livewire('/blog/{slug}', 'pages::site.blog.show')->name('site.blog.show');
});

Route::middleware('module:privacy')->group(function () {
    Route::livewire('/privacy', 'pages::site.privacy')->name('site.privacy');
});

Route::middleware('module:terms')->group(function () {
    Route::livewire('/terms', 'pages::site.terms')->name('site.terms');
});

Route::middleware('module:faq')->group(function () {
    Route::livewire('/faq', 'pages::site.faq')->name('site.faq');
});

Route::middleware('module:services')->group(function () {
    Route::livewire('/services', 'pages::site.services.index')->name('site.services.index');
    Route::livewire('/services/{slug}', 'pages::site.services.show')->name('site.services.show');
});
