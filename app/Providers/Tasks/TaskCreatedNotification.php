<?php

namespace App\Providers\Tasks;

use App\Providers\Events\TaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TaskCreatedNotification
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
     * @param  \App\Providers\Events\TaskCreated  $event
     * @return void
     */
    public function handle(TaskCreated $event)
    {
        //
    }
}
