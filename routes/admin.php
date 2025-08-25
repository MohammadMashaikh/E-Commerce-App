<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\RolesController;

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware('guest.admin')->group(function () {
        Route::get('/', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('/', [AdminController::class, 'login'])->name('login.attempt');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');


        Route::controller(ProductsController::class)->group(function () {
            Route::get('/products/list', 'list')->name('products.list')->middleware('can:view-products');
            Route::get('/products/create', 'create')->name('products.create')->middleware('can:manage-products');
            Route::post('/products/store', 'store')->name('products.store')->middleware('can:manage-products');
            Route::get('/products/edit/{product}', 'edit')->name('products.edit')->middleware('can:manage-products');
            Route::put('/products/update/{id}', 'update')->name('products.update')->middleware('can:manage-products');
            Route::delete('/products/delete/{id}', 'delete')->name('products.delete')->middleware('can:manage-products');
        });


        Route::controller(AdminUsersController::class)->group(function () {
            Route::get('/users/list', 'list')->name('users.list')->middleware('can:view-users');
            Route::get('/users/create', 'create')->name('users.create')->middleware('can:manage-users');
            Route::post('/users/store', 'store')->name('users.store')->middleware('can:manage-users');
            Route::get('/users/edit/{user}', 'edit')->name('users.edit')->middleware('can:manage-users');
            Route::put('/users/update/{id}', 'update')->name('users.update')->middleware('can:manage-users');
            Route::delete('/users/delete/{id}', 'delete')->name('users.delete')->middleware('can:manage-users');
        });


        Route::controller(RolesController::class)->group(function () {
            Route::get('/roles/list', 'list')->name('roles.list')->middleware('can:view-roles');
            Route::get('/roles/create', 'create')->name('roles.create')->middleware('can:manage-roles');
            Route::post('/roles/store', 'store')->name('roles.store')->middleware('can:manage-roles');
            Route::get('/roles/edit/{role}', 'edit')->name('roles.edit')->middleware('can:manage-roles');
            Route::put('/roles/update/{id}', 'update')->name('roles.update')->middleware('can:manage-roles');
            Route::delete('/roles/delete/{id}', 'delete')->name('roles.delete')->middleware('can:manage-roles');
        });


        Route::get('/orders/list', [OrdersController::class, 'list'])->name('orders.list')->middleware('can:view-orders');
        Route::get('/orders/approve/{id}', [OrdersController::class, 'approve'])->name('orders.approve')->middleware('can:manage-orders');
        Route::get('/orders/decline/{id}', [OrdersController::class, 'decline'])->name('orders.decline')->middleware('can:manage-orders');

    });
});

