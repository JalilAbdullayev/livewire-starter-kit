<?php

use App\Support\LocalizedRoute;

LocalizedRoute::register([
    [
        'name' => 'home',
        'component' => 'pages::site.home',
    ],
    [
        'name' => 'site.about',
        'component' => 'pages::site.about',
        'middleware' => ['module:about'],
    ],
    [
        'name' => 'site.contact',
        'component' => 'pages::site.contact',
        'middleware' => ['module:contact'],
    ],
    [
        'name' => 'site.blog.index',
        'component' => 'pages::site.blog.index',
        'middleware' => ['module:blog'],
    ],
    [
        'name' => 'site.blog.show',
        'component' => 'pages::site.blog.show',
        'middleware' => ['module:blog'],
    ],
    [
        'name' => 'site.privacy',
        'component' => 'pages::site.privacy',
        'middleware' => ['module:privacy'],
    ],
    [
        'name' => 'site.terms',
        'component' => 'pages::site.terms',
        'middleware' => ['module:terms'],
    ],
    [
        'name' => 'site.faq',
        'component' => 'pages::site.faq',
        'middleware' => ['module:faq'],
    ],
    [
        'name' => 'site.services.index',
        'component' => 'pages::site.services.index',
        'middleware' => ['module:services'],
    ],
    [
        'name' => 'site.services.show',
        'component' => 'pages::site.services.show',
        'middleware' => ['module:services'],
    ],
]);
