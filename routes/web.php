<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductsController::class, 'list'])->name('home');


Route::prefix('shop')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});



Route::middleware('auth')->group(function () {
    Route::get('/orders/list', [OrdersController::class, 'list'])->name('orders.list');
    Route::get('/orders/show/{id}', [OrdersController::class, 'show'])->name('orders.show');
    Route::get('/orders/json/{id}', [OrdersController::class, 'json'])->name('orders.json');
});

require __DIR__.'/auth.php';
