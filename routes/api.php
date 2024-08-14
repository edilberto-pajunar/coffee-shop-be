<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderItemController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("register", [AuthenticationController::class, "register"]);
Route::post("login", [AuthenticationController::class, "login"]);

Route::group([
    "prefix" => "users",
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get("", [UserController::class, "index"]);
    Route::get("token-check", [UserController::class, "checkToken"]);

});

// products

Route::group([
    "prefix" => "products",
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get("", [ProductController::class, "index"]);
    Route::get("categories/{id}", [ProductController::class, "show"]);
});

Route::group([
    "prefix" => "orders",
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get("", [OrderController::class, "show"]);
    Route::post("/add", [OrderController::class, "store"]);
    Route::get("", [OrderController::class, "getOrders"]);
});

Route::group([
    "prefix" => "order-items",
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get("{userId}", [OrderItemController::class, "getOrderItemsWithProducts"]);
});

// Route::post("v1/register", [UserController::class, "register"]);
// Route::post("v1/addProduct", [ProductController::class, "addProduct"]);
