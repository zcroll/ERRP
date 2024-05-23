<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ds('hell');
//    ds()->routes();
    Log::info('Your message', ['12' => 'Your Context']);
    return view('welcome');
});
