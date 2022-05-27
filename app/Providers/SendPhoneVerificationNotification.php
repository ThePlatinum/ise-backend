<?php

namespace App\Providers;

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
        // TODO: Send SMS with OTP
        $otp = $this->generateOTP();
    }

    public function generateOTP(){
        $otp = rand(100000, 999999);
        return $otp;
    }
}
