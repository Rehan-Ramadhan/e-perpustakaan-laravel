<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('buku', BukuController::class);
