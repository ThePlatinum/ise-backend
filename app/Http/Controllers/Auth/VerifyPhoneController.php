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
    $this->basic  = new \Vonage\Client\Credentials\Basic(env("SMS_API_KEY",""), env("SMS_API_SECRET",""));
    $this->client = new \Vonage\Client($this->basic);
  }

  public function sendSMS($user)
  {
    if ($user->phone_verified) {
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
    if ($verification->count() > 0) $verification->delete();

    PhoneVerification::updateOrCreate([
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

    $result = $this->client->verify()->check($REQUEST_ID, $CODE);
    $status = $result->getResponseData();
    if ($status == 0) {
      $verification->delete();
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }
}
