<?php

use App\Http\Controllers\Api\AdminUsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\ProductsController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:admin-api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::controller(ProductsController::class)->prefix('products')->group(function () {
        Route::get('/list', 'list');
        Route::get('/show/{product}', 'show');
        Route::post('/store', 'store');
        Route::delete('/delete/{product}', 'delete');
    });


    Route::controller(AdminUsersController::class)->prefix('users')->group(function () {
        Route::get('/list', 'list');
        Route::get('/show/{user}', 'show');
        Route::post('/store', 'store');
        Route::delete('/delete/{id}', 'delete');
    });


    Route::controller(OrdersController::class)->prefix('orders')->group(function () {
        Route::get('/list', 'list');
        Route::get('/show/{order}', 'show');
        Route::post('/approve/{id}', 'approve');
        Route::post('/decline/{id}', 'decline');
    });
});
