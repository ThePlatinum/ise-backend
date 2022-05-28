<?php

namespace App\Providers;

use App\Http\Controllers\Auth\VerifyPhoneController;
use App\Providers\AddPhone;
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
     * @param  \App\Providers\AddPhone  $event
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
