<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\AddPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EditController extends Controller
{
  /**
   * Update a user's bio note.
   *
   * @return \Illuminate\Http\Response
   */
  public function about(Request $request)
  {
    //
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'bio' => 'required|string|min:3|max:255',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors(),
      ], 422);
    }

    $user = User::find($request->user_id);
    if (!$user) {
      return response()->json([
        'status' => 'error',
        'errors' => 'User not found',
      ], 404);
    }

    $user->bio = $request->bio;
    $user->save();

    return response()->json([
      'message' => 'Bio note added successfully',
    ], 200);
  }

  /**
   * Update a user's phone number
   *
   * @return \Illuminate\Http\Response
   */
  public function phone(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'phone' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors(),
      ], 422);
    }

    $user = User::find($request->user_id);
    if (!$user) {
      return response()->json([
        'status' => 'error',
        'errors' => 'User not found',
      ], 404);
    }

    if ($request->phone == $user->phone) {
      return response()->json([
        'status' => 'error',
        'errors' => 'Phone number is already set',
      ], 422);
    }

    $user->phone = $request->phone;
    $user->phone_verified_at = null;
    $user->save();

    event(new AddPhone($user));

    return response()->json([
      'message' => 'Phone number added successfully',
    ], 200);
  }

  /**
   * Update a user's basic informaions
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function basics(Request $request)
  {
    //
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'state' => 'nullable|string|max:255',
      'country' => 'nullable|string|max:255',
      'dob' => 'nullable|string|max:255',
      'gender' => ['nullable', Rule::in(['m', 'f'])]
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors(),
      ], 422);
    }

    $user = User::find($request->user_id);
    if (!$user) {
      return response()->json([
        'status' => 'error',
        'errors' => 'User not found',
      ], 404);
    }

    if ($request->has('state'))
      $user->state = $request->state;
    if ($request->has('country'))
      $user->country = $request->country;
    if ($request->has('dob'))
      $user->dob = $request->dob;
    if ($request->has('gender'))
      $user->gender = $request->gender;

    $user->save();

    return response()->json([
      'message' => 'profile updated successfully',
    ], 200);
  }

  /**
   * Update a user's password
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function password(Request $request)
  {
    // 
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'old' => 'required|string|min:6|max:255',
      'new' => 'required|string|min:6|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'errors' => $validator->errors(),
      ], 422);
    }

    $user = User::find($request->user_id);
    if (!$user) {
      return response()->json([
        'status' => 'error',
        'errors' => 'User not found',
      ], 404);
    }

    if ($request->new == $request->old) {
      return response()->json([
        'status' => 'error',
        'errors' => 'New password cannot be the same as the old password',
      ], 422);
    }

    if (!password_verify($request->old, $user->password)) {
      return response()->json([
        'status' => 'error',
        'errors' => 'Old password is incorrect',
      ], 422);
    } else {
      $user->password = Hash::make($request->new);
      $user->save();

      return response()->json([
        'message' => 'Password updated successfully',
      ], 200);
    }

    // TODO: Send email to user to notify of the new password change
    // TODO: Log user out
  }
}
