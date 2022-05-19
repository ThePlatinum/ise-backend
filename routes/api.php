<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ProfileController;
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
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

// Route::group( ['middleware'=>['auth:sanctum']], function () {
  Route::get('/getprofile/{user_id}',  [ProfileController::class, 'getprofile']);

  Route::get('/logout/{user_id}',  [UserController::class, 'logout']);
// });
