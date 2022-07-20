<?php

namespace App\Providers\Identity;

use App\Providers\Events\IdentityDocumentSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IdentityDocumentSubmittedNotification
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
   * @param  \App\Providers\Events\IdentityDocumentSubmitted  $event
   * @return void
   */
  public function handle(IdentityDocumentSubmitted $event)
  {
    //
    $user = $event->user;
    $submited = $event->submited;

    $user->submited_doc = true;
    $user->save();
  }
}
