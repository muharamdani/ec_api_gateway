<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// List of RestfulAPI without Authorization placed outside group function
// User Service
Route::controller(AuthController::class)
    ->prefix('user')
    ->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });

// Product Service
Route::get('products/store/{id}', [ProductController::class, 'productsByStore']);
Route::resource('products', ProductController::class)
    ->only(['index', 'show', 'destroy']);

// Store Service
Route::prefix('stores')
    ->controller(StoreController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/user/{id}', 'showByUser');
    });

Route::middleware('user_auth')->group(function () {
    // User Service API
    Route::controller(AuthController::class)
        ->prefix('user')
        ->group(function () {
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
            Route::get('profile', 'profile');
    });
    // Product Service API
    Route::resource('products', ProductController::class)
        ->only(['store', 'update', 'destroy']);

    // Store Service API
    Route::post('/stores', [StoreController::class, 'store']);
});
