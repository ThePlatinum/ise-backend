<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\AddPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
  public function getprofile($user_id)
  {
    $user = User::find($user_id);
    if (!$user)
      return response()->json(400);
    return response()->json($user, 200);
  }

  public function usernameandphone(Request $request){
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'username' => 'required|unique:users|string|max:255',
      'country' => 'required|string|max:255',
      'phone' => 'required|unique:users|string',
    ]);
    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()], 401);
    }
    $user = User::find($request->user_id);
    if (!$user)
      return response()->json(400);
    $user->username = $request->username;
    $user->country_of_residence = $request->country;
    $user->phone = $request->phone;
    $user->save();

    event (new AddPhone($user));

    return response()->json(['Details set'], 200);
  }

  public function basicinfo(Request $request){
    $validator = Validator::make($request->all(), [
      'user_id' => 'required|exists:users,id',
      'firstname' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      'othername' => 'string|max:255',
      'gender' => 'required|string',
      'dob' => 'required|date',
      'state_of_residence' => 'required|string',
      'state_of_origin' => 'required|string',
      'country_of_origin' => 'required|string'
    ]);
    if ($validator->fails())
      return response(['status' => false, 'message' => $validator->errors()->all()], 200);
    else
      $user = User::find($request->user_id);
    abort_if(!$user, 404);
    $user->firstname = $request->firstname;
    $user->lastname = $request->lastname;
    $user->othername = $request->othername;
    $user->gender = $request->gender;
    $user->dob = $request->dob;
    $user->state_of_origin = $request->state_of_origin;
    $user->country_of_origin = $request->country_of_origin;
    $user->state_of_residence = $request->state_of_residence;

    $user->save();
    return response()->json(['status' => true, 'message' => 'Details set'], 200);
  }

  public function setprofilepicture(Request $request)
  {
    // TODO: Delete previous img if exist
    $validator = Validator::make($request->all(), ['image' => 'image|mimes:jpeg,png,jpg,svg']);
    if ($validator->fails())
      return response(['status' => false, 'message' => $validator->errors()->all()], 200);
    else
      $user = User::find($request->user_id);
    if ($user) {
      $file = $request->file('image');
      $file->storeAs('public/profile_images', $file->getClientOriginalName());
      $image = 'profile_images/' . $file->getClientOriginalName();
      $user->profile_image = $image;
      $user->save();
      return response(['status' => true, 'message' => "Profile picture updated"], 200);
    } else
      return response(['status' => false, 'message' => 'User not found'], 400);
  }
}
