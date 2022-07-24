<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Account\EditController;
use App\Http\Controllers\Account\PortfolioController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Http\Controllers\Identity\DocumentController;
use App\Http\Controllers\MailsController;
use App\Http\Controllers\Account\ProfileController;
use App\Http\Controllers\Payments\OrderController;
use App\Http\Controllers\Super\SuperController;
use App\Http\Controllers\Tasks\ReviewController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Tasks\UserTaskController;
use App\Models\Categories;


/*
| API Routes
*/


//Auths
Route::POST('login', [UserController::class, 'login']);
Route::POST('register', [UserController::class, 'register']);

// Categories
Route::GET('categories', function () {
    $allcat = Categories::get();
    return response($allcat, 200);
});

// Identity Documents
Route::GET('accepteddocs', [DocumentController::class, 'acceptedDocuments']);

// Tasks
Route::GET('tasks', [TaskController::class, 'alltasks']);
Route::GET('tasks/get/{task_slug}', [TaskController::class, 'get_task']);
Route::GET('tasks/{category_slug}', [TaskController::class, 'tasks']);
Route::GET('task/search', [TaskController::class, 'search']);
Route::GET('tasks/of/{user_id}', [UserTaskController::class, 'show_all']);
Route::GET('tasks/approved/of/{user_id}', [UserTaskController::class, 'show_approved']);
Route::GET('tasks/not_approved/of/{user_id}', [UserTaskController::class, 'show_approved']);

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::POST('email/verification-notification', [VerifyEmailController::class, 'resendNotification'])
    ->name('verification.send');

  // Profile
  // TODO: Make this call once
  Route::POST('usernameandphone', [ProfileController::class, 'usernameandphone']);

  // Phone verification
  Route::POST('resend-phone', [VerifyPhoneController::class, 'resend']);
  Route::POST('call-phone', [VerifyPhoneController::class, 'nextascall']);
  Route::POST('verify-phone', [VerifyPhoneController::class, 'verify']);

  Route::GET('logout/{user_id}',  [UserController::class, 'logout']);
});

// TODO: sanctum auth must check user's id
// Must verify email require passing USER_ID as param or request
Route::group(['middleware' => ['auth:sanctum', 'mustverify']], function () {

  // Profile
  Route::GET('getprofile/{user_id}',  [ProfileController::class, 'getprofile']);
  Route::POST('basicinfo', [ProfileController::class, 'basicinfo']);
  Route::POST('setprofilepicture',  [ProfileController::class, 'setprofilepicture']);
  Route::POST('profile/bio',  [EditController::class, 'about']);
  Route::POST('profile/password',  [EditController::class, 'password']);
  Route::POST('profile/phone',  [EditController::class, 'phone']);
  Route::POST('profile/basics',  [EditController::class, 'basics']);
  Route::POST('profile/skills',  [EditController::class, 'skills']);

  // Task
  Route::POST('task/new', [TaskController::class, 'store']);
  Route::POST('task/update/{task_id}', [TaskController::class, 'update']);
  Route::POST('task/delete', [TaskController::class, 'delete']);
  Route::POST('task/review', [ReviewController::class, 'store']);

  // Identity Documents
  Route::POST('identity/submit', [DocumentController::class, 'submitdoc']);

  // Portfolio
  Route::POST('portfolio/new', [PortfolioController::class, 'create']);
  Route::POST('portfolio/update', [PortfolioController::class, 'update']);
  Route::GET('portfolio/delete/{user_id}/{portfolio_id}', [PortfolioController::class, 'delete']);
  Route::GET('portfolio/get/{user_id}', [PortfolioController::class, 'show']);

  // Payments
  Route::GET('paymentreturn', [OrderController::class, 'paymentreturn']);

  Route::GET('welcomemail/{user_id}', [MailsController::class, 'welcome']);
});

  Route::POST('order_task', [OrderController::class, 'order_task']);

// Super
Route::GET('migrate', [SuperController::class, 'migrate']);
