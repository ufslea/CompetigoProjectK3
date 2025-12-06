<?php

namespace App\Providers;

use App\Events\PartisipanVerified;
use App\Events\PartisipanRejected;
use App\Events\ResultCreated;
use App\Events\AnnouncementCreated;
use App\Listeners\SendVerificationNotification;
use App\Listeners\SendRejectionNotification;
use App\Listeners\SendResultNotification;
use App\Listeners\SendAnnouncementNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        PartisipanVerified::class => [
            SendVerificationNotification::class,
        ],
        PartisipanRejected::class => [
            SendRejectionNotification::class,
        ],
        ResultCreated::class => [
            SendResultNotification::class,
        ],
        AnnouncementCreated::class => [
            SendAnnouncementNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
