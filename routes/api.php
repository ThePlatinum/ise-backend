<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Http\Controllers\Identity\DocumentController;
use App\Http\Controllers\MailsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Super\SuperController;
use App\Http\Controllers\TaskController;
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
Route::POST('login', [UserController::class, 'login']);
Route::POST('register', [UserController::class, 'register']);

// Categories
Route::GET('categories', [ProjectsController::class, 'categories']);


// Tasks
Route::GET('tasks', [TaskController::class, 'alltasks']);
Route::GET('tasks/{category_id}', [TaskController::class, 'tasks']);
Route::GET('task/search', [TaskController::class, 'search']);
Route::GET('tasks/of/{user_id}', [TaskController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::POST('email/verification-notification', [VerifyEmailController::class, 'resendNotification'])
    ->name('verification.send');

  // Profile
  Route::POST('usernameandphone', [ProfileController::class, 'usernameandphone']);
  
  // Phone verification
  Route::POST('resend-phone', [VerifyPhoneController::class, 'resend']);
  Route::POST('call-phone', [VerifyPhoneController::class, 'nextascall']);
  Route::POST('verify-phone', [VerifyPhoneController::class, 'verify']);

  Route::GET('logout/{user_id}',  [UserController::class, 'logout']);
});

// Must verify email require passing USER_ID as param or request
Route::group(['middleware' => ['auth:sanctum', 'mustverify']], function () {

  // Profile
  Route::GET('getprofile/{user_id}',  [ProfileController::class, 'getprofile']);
  Route::POST('basicinfo', [ProfileController::class, 'basicinfo']);
  Route::POST('setprofilepicture',  [ProfileController::class, 'setprofilepicture']);

  // Task
  Route::POST('task/new', [TaskController::class, 'store']);
  Route::POST('task/update/{task_id}', [TaskController::class, 'update']);
  Route::POST('task/delete', [TaskController::class, 'delete']);

  // Identity Documents
  Route::POST('identity/submit', [DocumentController::class, 'submitdoc']);
  
  Route::GET('welcomemail/{user_id}', [MailsController::class, 'welcome']);
});


// Super
Route::GET('migrate', [SuperController::class, 'migrate']);