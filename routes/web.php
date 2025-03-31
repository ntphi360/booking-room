<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\UserAccountController;





Route::get('/', function () {
  return redirect(route('listings.index'));
});

// Routes cho listings (Công khai và yêu cầu đăng nhập)
Route::resource('listings', ListingController::class)
  ->only(['index', 'show']);

Route::resource('listings', ListingController::class)
  ->only(['create', 'store', 'edit', 'update'])
  ->middleware('auth');

// Auth Routes
Route::controller(AuthController::class)->group(function () {
  Route::get('login', 'create')->name('login');
  Route::post('login', 'store')->name('login.store');
  Route::delete('logout', 'destroy')->name('logout');
});

// User Account
Route::resource('user-account', UserAccountController::class)
  ->only(['create', 'store']);

// Realtor Listings - Chỉ dành cho realtor (yêu cầu đăng nhập)
Route::prefix('realtor')
  ->name('realtor.')
  ->middleware('auth')
  ->group(function () {
      Route::resource('listings', RealtorListingController::class)
          ->only(['index', 'destroy']);
  });