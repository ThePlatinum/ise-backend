<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify($id, $hash)
    {
        $user = User::find($id);
        abort_if(!$user, 403);
        abort_if(!hash_equals($hash, sha1($user->getEmailForVerification())), 403);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return view('auth.verified');
    }

    public function resendNotification(Request $request) {
        $user = User::find($request->user_id);
        abort_if(!$user, 403);
        
        $user->sendEmailVerificationNotification();

        return ['message'=> 'Verification link sent successfully'];
    }
}