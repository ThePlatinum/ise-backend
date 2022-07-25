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
      Identity\IdentityDocumentSubmittedNotification::class,
    ],
    Events\IdentityDocumentStatusChanged::class => [
      Identity\IdentityDocumentStatusChangedNotification::class,
    ],
    Events\TaskCreated::class => [
      Tasks\TaskCreatedNotification::class,
    ],
    Events\TaskStatusChanged::class => [
      Tasks\TaskStatusChangedNotification::class,
    ],
    Events\OrderCreated::class => [
      Order\OrderCreatedNotification::class,
    ],
    Events\OrderAccepted::class => [
      Order\OrderAcceptedNotification::class,
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
