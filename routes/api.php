<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("register", [AuthenticationController::class, "register"]);
Route::post("login", [AuthenticationController::class, "login"]);


Route::get("users", [UserController::class, "index"]);


// Route::post("v1/register", [UserController::class, "register"]);
// Route::post("v1/addProduct", [ProductController::class, "addProduct"]);
