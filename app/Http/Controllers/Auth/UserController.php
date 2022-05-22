<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6'
    ]);
    if ($validator->fails()) {
      $response = ['status' => false, 'message' => $validator->errors()->all()];
      return response($response, 200);
    }

    $request['password'] = Hash::make($request['password']);
    $request['remember_token'] = Str::random(10);

    $user = User::create($request->toArray());
    $token = $user->createToken('Ise Password Grant Client')->plainTextToken;

    $response = ['status' => true, 'token' => $token, 'message' => 'You have successfully registered!'];
    return response($response, 200);
  }

  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:6',
    ]);
    if ($validator->fails()) {
      $status = false;
      $response = ['status' => $status, 'message' => $validator->errors()->all()];
      return response($response, 200);
    }
    $user = User::where('email', $request->email)->first();
    if ($user)
      if (Hash::check($request->password, $user->password)) {
        $token = $user->createToken('Ise Password Grant Client')->plainTextToken;

        $response = ['status' => true, 'token' => $token,  "user_id" => $user->id, 'message' => 'Successfully logged in!'];
        return response($response, 200);
      } else
        return response(['status' => false, "message" => "Password mismatch"]);
    else
      return response(['status' => false, "message" => 'User does not exist'], 200);
  }

  public function logout($user_id)
  {
    $token = User::where('id', $user_id)->user()->token();
    $token->revoke();
    return response(['status' => true, 'message' => 'Successfully logged out!'], 200);
  }
}
