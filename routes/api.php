<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\Super\SuperController;
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

Route::group( ['middleware'=>['auth:sanctum']], function () {
  Route::GET('/getprofile/{user_id}',  [ProfileController::class, 'getprofile']);
  Route::POST('/setprofilepicture',  [ProfileController::class, 'setprofilepicture']);

  Route::GET('/logout/{user_id}',  [UserController::class, 'logout']);
});
