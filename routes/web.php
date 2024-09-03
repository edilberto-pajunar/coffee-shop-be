<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });


Route::view("/", "home");

Route::view("/success", "success");
Route::view("/failed", "failed");
Route::view("/cancelled", "cancelled");