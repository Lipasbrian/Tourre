<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;

Route::get('/', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours', [TourController::class, 'index'])->name('tours.list');
Route::get('/tours/{id}', [TourController::class, 'show'])->name('tours.show');

Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
