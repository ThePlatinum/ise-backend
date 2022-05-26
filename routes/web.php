<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
})->middleware('guest');

Auth::routes(); // Same as using resource

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
  
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
  ->middleware(['signed'])->name('verification.verify');