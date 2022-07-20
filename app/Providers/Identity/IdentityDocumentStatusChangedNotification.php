<?php

namespace App\Providers\Identity;

use App\Providers\Events\IdentityDocumentStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IdentityDocumentStatusChangedNotification
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
     * @param  \App\Providers\Events\IdentityDocumentStatusChanged  $event
     * @return void
     */
    public function handle(IdentityDocumentStatusChanged $event)
    {
        //
    }
}
