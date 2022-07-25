<?php

namespace App\Providers\Order;

use App\Providers\Events\OrderAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderAcceptedNotification
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
     * @param  \App\Providers\Events\OrderAccepted  $event
     * @return void
     */
    public function handle(OrderAccepted $event)
    {
        //
    }
}
