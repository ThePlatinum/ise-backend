<?php

namespace App\Providers;

use App\Providers\IdentityDocumentStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendIdentityDocumentStatusChangedNotification
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
     * @param  \App\Providers\IdentityDocumentStatusChanged  $event
     * @return void
     */
    public function handle(IdentityDocumentStatusChanged $event)
    {
        //
    }
}
