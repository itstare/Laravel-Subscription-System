<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/payments/pay', [App\Http\Controllers\PaymentController::class, 'pay'])->name('pay');
Route::get('/payments/approval', [App\Http\Controllers\PaymentController::class, 'approval'])->name('approval');
Route::get('/payments/cancelled', [App\Http\Controllers\PaymentController::class, 'cancelled'])->name('cancelled');

Route::get('/subscribe', [App\Http\Controllers\SubscriptionController::class, 'show'])->middleware(['auth', 'unsubscribed'])->name('subscription.show');
Route::post('/subscribe/store', [App\Http\Controllers\SubscriptionController::class, 'store'])->middleware(['auth', 'unsubscribed'])->name('subscription.store');
Route::get('/subscribe/approval', [App\Http\Controllers\SubscriptionController::class, 'approval'])->middleware(['auth', 'unsubscribed'])->name('subscription.approval');
Route::get('/subscribe/cancelled', [App\Http\Controllers\SubscriptionController::class, 'cancelled'])->middleware(['auth', 'unsubscribed'])->name('subscription.cancelled');
