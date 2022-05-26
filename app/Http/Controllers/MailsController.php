<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailsController extends Controller
{
  //
  // public function verifyphone($user_id)
  // {
  //   $user = User::find($user_id);
  //   if (!$user)
  //     return response()->json(400);
  //   Mail::to('platinumemirate@gmail.com')->send(new WelcomeMail($user));
  //   return response()->json(200);
  // }

  //
  public function welcome($user_id)
  {
    $user = User::find($user_id);
    if (!$user)
      return response()->json(400);
    Mail::to('platinumemirate@gmail.com')->send(new WelcomeMail($user));
    return response()->json(200);
  }
}
