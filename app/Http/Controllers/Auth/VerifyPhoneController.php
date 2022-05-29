<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PhoneVerification;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyPhoneController extends Controller
{
  //
  private $basic;
  private $client;

  function  __construct()
  {
    $this->basic  = new \Vonage\Client\Credentials\Basic(config('global.SMS_API_KEY'), config('global.SMS_API_SECRET'));
    $this->client = new \Vonage\Client($this->basic);
  }

  public function sendSMS($user)
  {
    if ($user->phone_verified_at) {
      return ['message' => 'Phone number already verified'];
    }
    
    $NUMBER = $user->phone;
    try {
      $request = new \Vonage\Verify\Request($NUMBER, "ISE");
    } catch (\Exception $e) {
      return ['message' => 'An error occured or, maybe an invalid phone number is provided'];
    }
    $response = $this->client->verify()->start($request);

    $verification = PhoneVerification::where('user_id', $user->id)->first();
    if ($verification) $verification->delete();

    PhoneVerification::create([
      'user_id' => $user->id,
      'verification_id' => $response->getRequestId()
    ]);

    return ['message' => 'Phone number verification code sent'];
  }

  public function resend(Request $request)
  {
    $user = User::find($request->user_id);
    $result = $this->sendSMS($user);
    return response()->json($result, 200);
  }

  public function verify(Request $request)
  {
    $verification = PhoneVerification::where('user_id', $request->user_id)->first();

    $REQUEST_ID = $verification->verification_id;
    $CODE = $request->code;

    try {
      $result = $this->client->verify()->check($REQUEST_ID, $CODE);
    } catch (\Exception $e) {
      //throw $th;
      $result = null;
    }
    
    // $status = $result->getResponseData();
    if ($result) {
      $verification->delete();

      $user = User::find($request->user_id);
      $user->phone_verified_at = now();
      $user->save();

      return response()->json(['message' => 'Phone number verified successfully'], 200);
    } else {
      return response()->json(['message' => 'Incorrect code'], 401);
    }
  }

  public function nextascall(Request $request)
  {
    $verification = PhoneVerification::where('user_id', $request->user_id)->first();
    $REQUEST_ID = $verification->verification_id;

    $this->client->verify()->trigger($REQUEST_ID);

    return response()->json(['message' => 'Call initiated', 'success' => true], 200);
  }
}
