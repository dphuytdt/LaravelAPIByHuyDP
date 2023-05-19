<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('login')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
});

Route::get('/profile/{id}', [AuthController::class, 'profile'])->name('profile');

Route::put('/profile/{id}', [AuthController::class, 'updateProfile'])->name('updateProfile');

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::post('/', [CartController::class, 'store'])->name('cart.store');
        Route::put('/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::delete('/', [CartController::class, 'destroyAll'])->name('cart.destroyAll');
    });
});