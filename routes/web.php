<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaypalController;

Route::get('/welcome', function () {
    return view('welcome');
})->name('home');

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/success', function () {
    return view('success');
})->name('success');


Route::get('/home', [PaypalController::class ,'index'])->name('service')->middleware('auth');
Route::post('generate_link', [PaypalController::class ,'generate_link'])->name('generate_link')->middleware('auth');
Route::get('paywithpaypal/{code}', [PaypalController::class ,'payWithPaypal'])->name('paywithpaypal')->middleware('auth');
Route::post('paypal', [PaypalController::class,'postPaymentWithpaypal'])->name('paypal')->middleware('auth');
Route::get('status', [PaypalController::class,'getPaymentStatus'])->name('status')->middleware('auth');
Auth::routes();

Route::get('/logout', [PaypalController::class ,'logout'])->name('logout');
