<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

use function Laravel\Prompts\search;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
Route::resource('buku', BukuController::class);

