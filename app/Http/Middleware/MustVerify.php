<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class MustVerify
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    $user_id = $request->route('user_id');
    if ( ! $user_id) {
      $user_id = $request->user_id;
    }
    $user = User::find($user_id);
    if (!$user)
      return abort(403);
      
    if (! $user->hasVerifiedEmail() ) {
      return response()->json([
        'message' => 'You must verify your account.',
        'status' => false,
        'email_verified_at' => $user->email_verified_at,
        'phone' => $user->phone,
        'phone_verified_at' => $user->phone_verified_at,
        'submited_doc' => $user->submited_doc,
        'identified' => $user->identified,
      ], 200);
    }
    
    return $next($request);
  }
}
