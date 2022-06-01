<?php

namespace App\Providers\Identity;

use App\Providers\IdentityDocumentSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendIdentityDocumentSubmittedNotification
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
     * @param  \App\Providers\IdentityDocumentSubmitted  $event
     * @return void
     */
    public function handle(IdentityDocumentSubmitted $event)
    {
        //
    }
}
