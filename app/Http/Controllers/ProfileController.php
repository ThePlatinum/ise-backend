<?php

namespace App\Http\Controllers;

use App\Models\User;
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

  public function setprofilepicture(Request $request)
  {
    $validator = Validator::make($request->all(), ['image' => 'image|mimes:jpeg,png,jpg,svg']);
    if ($validator->fails())
      return response(['status' => false, 'message' => $validator->errors()->all()], 200);
    else
      $user = User::find($request->user_id);
    if ($user) {
      $file = $request->file('image');
      $file->storeAs('profile_images', $file->getClientOriginalName());
      $image = 'profile_images/' . $file->getClientOriginalName();
      $user->profile_image = $image;
      $user->save();
      return response(['status' => true, 'message' => "Profile picture updated"], 200);
    } else
      return response(['status' => false, 'message' => 'User not found'], 400);
  }
}
