<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MailsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Super\SuperController;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auths
Route::POST('/login', [UserController::class, 'login']);
Route::POST('/register', [UserController::class, 'register']);

Route::GET('/categories', [ProjectsController::class, 'categories']);
Route::GET('/migrate', [SuperController::class, 'migrate']);

Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])
  ->name('verification.send');

Route::group(['middleware' => ['auth:sanctum']], function () {

  Route::GET('/logout/{user_id}',  [UserController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum', 'mustverify']], function () {
  Route::GET('/getprofile/{user_id}',  [ProfileController::class, 'getprofile']);
  Route::POST('/setprofilepicture',  [ProfileController::class, 'setprofilepicture']);
  Route::GET('/welcomemail/{user_id}', [MailsController::class, 'welcome']);
});
