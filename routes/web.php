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

// Auth Routes Login
Route::controller(AuthController::class)->group(function () {
  Route::get('login', 'create')->name('login');
  Route::post('login', 'store')->name('login.store');
  Route::delete('logout', 'destroy')->name('logout');
});

// User Account
Route::resource('user-account', UserAccountController::class)
  ->only(['create', 'store']);

// Realtor Listings 
Route::prefix('realtor')
  ->name('realtor.')
  ->middleware('auth')
  ->group(function () {
      Route::name("listings.restore")->put('listings/{listing}/restore',[RealtorListingController::class,'restore'])->withTrashed();
      Route::resource('listings', RealtorListingController::class)
          ->only(['index', 'destroy','edit', 'update','create','store'])
          ->withTrashed();
  });