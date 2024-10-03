<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/products', App\Http\Controllers\Api\ProductController::class);
Route::apiResource('/categories', App\Http\Controllers\Api\CategoryController::class);
Route::apiResource('/customers', App\Http\Controllers\Api\CustomerController::class);
Route::apiResource('/users', App\Http\Controllers\Api\UserController::class);
Route::apiResource('/orders', App\Http\Controllers\Api\OrderController::class);
Route::apiResource('/checkouts', App\Http\Controllers\Api\CheckoutController::class);