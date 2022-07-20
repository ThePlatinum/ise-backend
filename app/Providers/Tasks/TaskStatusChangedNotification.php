<?php

namespace App\Providers\Tasks;

use App\Providers\Events\TaskStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskStatusChangedNotification
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
     * @param  \App\Providers\Events\TaskStatusChanged  $event
     * @return void
     */
    public function handle(TaskStatusChanged $event)
    {
        //
    }
}
