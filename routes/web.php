<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\WebControllers\TasksController;
use App\Http\Controllers\WebControllers\DashboardController;
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
Route::get('/login', function () {
  return view('auth.login');
})->middleware('guest');

Auth::routes(); // Same as using resource

Route::group(['middleware' => ['auth']], function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('tasks', [TasksController::class, 'index'])->name('tasks');
  Route::get('view', [TasksController::class, 'index'])->name('tasks.view');
});

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
  ->middleware(['signed'])->name('verification.verify');
