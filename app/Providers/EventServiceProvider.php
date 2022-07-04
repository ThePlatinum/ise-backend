<?php

namespace App\Providers;

use App\Models\Task;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array<class-string, array<int, class-string>>
   */
  protected $listen = [
    Registered::class => [
      SendEmailVerificationNotification::class,
    ],
    Events\AddPhone::class => [
      Profile\SendPhoneVerificationNotification::class,
    ],
    Events\CompleteProfile::class => [
      Profile\SendCompleteProfileNotification::class,
    ],
    Events\IdentityDocumentSubmitted::class => [
      Identity\SendIdentityDocumentSubmittedNotification::class,
    ],
    Events\IdentityDocumentStatusChanged::class => [
      Identity\SendIdentityDocumentStatusChangedNotification::class,
    ],
    Events\TaskCreated::class => [
      Tasks\SendTaskCreatedNotification::class,
    ],
    Events\TaskStatusChanged::class => [
      Tasks\SendTaskStatusChangedNotification::class,
    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
