<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApartmentViewController;

Route::get('/', function () {
    return redirect()->route('apartments.index');
});

Route::resource('apartments', ApartmentViewController::class);