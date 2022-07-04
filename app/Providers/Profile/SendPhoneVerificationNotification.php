<?php

namespace App\Providers\Profile;

use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Providers\Events\AddPhone;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPhoneVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\Events\AddPhone  $event
     * @return void
     */
    public function handle(AddPhone $event)
    {
        //
        $user = $event->user;
        
        $verify = new VerifyPhoneController();
        $verify->sendSMS($user);
    }
}
