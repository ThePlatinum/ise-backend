<?php

namespace App\Providers\Tasks;

use App\Providers\TaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskCreatedNotification
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
     * @param  \App\Providers\TaskCreated  $event
     * @return void
     */
    public function handle(TaskCreated $event)
    {
        //
    }
}
