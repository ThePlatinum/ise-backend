<?php

namespace App\Providers;

use App\Providers\TaskStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskStatusChangedNotification
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
     * @param  \App\Providers\TaskStatusChanged  $event
     * @return void
     */
    public function handle(TaskStatusChanged $event)
    {
        //
    }
}
