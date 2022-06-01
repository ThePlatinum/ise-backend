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
        AddPhone::class => [
            SendPhoneVerificationNotification::class,
        ],
        CompleteProfile::class => [
            Profile\SendCompleteProfileNotification::class,
        ],
        IdentityDocumentSubmitted::class => [
          Identity\SendIdentityDocumentSubmittedNotification::class,
        ],
        IdentityDocumentStatusChanged::class => [
          Identity\SendIdentityDocumentStatusChangedNotification::class,
        ],
        TaskCreated::class => [
          Tasks\SendTaskCreatedNotification::class,
        ],
        TaskStatusChanged::class => [
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
