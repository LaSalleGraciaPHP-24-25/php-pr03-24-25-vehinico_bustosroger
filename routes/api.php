<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\UserController;

// Rutas de autenticación
Route::post('/signin', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas de Apartments (protegidas con autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('apartments', ApartmentController::class);
    Route::post('/apartment-platform/{id}', [ApartmentController::class, 'updatePlatform']);
});

// Rutas adicionales
Route::get('/apartaments_rented', [ApartmentController::class, 'getByRentedStatus']);
Route::get('/apartaments_high_price', [ApartmentController::class, 'getByHighPrice']);