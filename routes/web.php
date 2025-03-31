<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\UserAccountController;

// Route::get('/',function(){
//   return redirect(route('listings.index'));
// });



Route::get('/', function () {
  return redirect(route('listings.index'));
});

// Bảo vệ các route chỉ dành cho user đã đăng nhập
Route::resource('listings', ListingController::class)
  ->middleware('auth')
  ->only(['create', 'store', 'edit', 'update', 'destroy']);

// Các route công khai
Route::resource('listings', ListingController::class)
  ->only(['index', 'show']);

// Auth Routes
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

// User Account
Route::resource('user-account', UserAccountController::class)
  ->only(['create', 'store']);

//Realtor 
Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth')
    ->group(function(){
      Route::resource('listings', RealtorListingController::class);
});