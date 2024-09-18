<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("register", [AuthenticationController::class, "register"]);
Route::post("login", [AuthenticationController::class, "login"]);
Route::post("logout", [AuthenticationController::class, "logout"])->middleware("auth:sanctum");

Route::group([
    "prefix" => "users",
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get("", [UserController::class, "index"]);
    Route::get("token-check", [UserController::class, "checkToken"]);
    Route::get("transactions", [TransactionController::class, "show"]);
    Route::get("{id}", [UserController::class, "info"]);
});

Route::group([
    "prefix" => "carts",
    "middleware" => ["auth:sanctum"]
], function() {
    Route::get("", [CartController::class, "show"]);
    Route::post("addToCart", [CartController::class, "addToCart"]);
    Route::post("removeToCart", [CartController::class, "removeToCart"]);
});

Route::group([
    "prefix" => "products",
    "middleware" => ["auth:sanctum"]
], function () {
    Route::get("", [ProductController::class, "index"]);
    Route::get("categories/{id}", [ProductController::class, "show"]);
    Route::get("search", [ProductController::class, "search"]);
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

Route::group([
    "prefix" => "stores",
    "middleware" => ["auth:sanctum"]
], function() {
    Route::get("", [StoreController::class, "index"]);
    Route::get("stream", [StoreController::class, "stream"]);
    Route::post("store", [StoreController::class, "store"]);
});

Route::group([
    "prefix" => "payments",
    "middleware" => ["auth:sanctum"]
], function() {
    Route::get("", [PaymentController::class, "index"]);
    Route::post("/generate_qr", [PaymentController::class, "generateQrCode"]);
}); 

Route::group([
    "prefix" => "wallets",
    "middleware" => ["auth:sanctum"]
], function() {
    Route::get("", [WalletController::class, "userWallet"]);
    Route::post("/top_up", [WalletController::class, "topUp"]);
    Route::post("/payment", [WalletController::class, "payment"]);

});