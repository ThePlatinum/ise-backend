<?php

namespace App\Providers;

use App\Providers\CompleteProfile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCompleteProfileNotification
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
     * @param  \App\Providers\CompleteProfile  $event
     * @return void
     */
    public function handle(CompleteProfile $event)
    {
        //
    }
}