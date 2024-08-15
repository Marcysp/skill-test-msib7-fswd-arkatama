<?php

use App\Http\Controllers\PenumpangController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

Route::resource('travel', TravelController::class);
Route::get('/', [TravelController::class, 'index']);
Route::get('/penumpang/create', [PenumpangController::class, 'create'])->name('penumpang.create');
Route::post('/penumpang', [PenumpangController::class, 'store'])->name('penumpang.store');
