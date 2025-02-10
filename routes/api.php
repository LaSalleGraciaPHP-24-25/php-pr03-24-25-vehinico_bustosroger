<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\UserController;

Route::post('/signin', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('apartments', ApartmentController::class);
    Route::post('/apartment-platform/{id}', [ApartmentController::class, 'updatePlatform']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('platforms', PlatformController::class);
});

Route::middleware('auth:sanctum')->get('/apartments_rented', [ApartmentController::class, 'getApartmentsByRentedStatus']);
Route::get('/apartaments_high_price', [ApartmentController::class, 'getByHighPrice']);
