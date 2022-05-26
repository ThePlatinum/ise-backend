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
    $user = User::find($user_id);
    if (!$user)
      return abort(403);
      
    if (! $user->hasVerifiedEmail() ) {
      return response()->json([
        'message' => 'You must verify your email address before continuing.',
        'status' => false,
      ], 200);
    }
    
    return $next($request);
  }
}
