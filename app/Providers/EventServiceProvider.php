<?php

namespace App\Providers;

use App\Events\AdminAddedEvent;
use App\Events\OrderCompletedEvent;
use App\Events\UserCacheFlushEvent;
use App\Listeners\NotifyAdminAddedListener;
use App\Listeners\NotifyAdminListener;
use App\Listeners\NotifyInfluencerListener;
use App\Listeners\UserCacheFlushListener;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCompletedEvent::class => [
            NotifyAdminListener::class,
            NotifyInfluencerListener::class,
        ],
        AdminAddedEvent::class => [
            NotifyAdminAddedListener::class,
        ],
        UserCacheFlushEvent::class => [
            UserCacheFlushListener::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
