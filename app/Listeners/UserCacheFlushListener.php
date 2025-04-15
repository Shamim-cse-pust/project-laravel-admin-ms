<?php

namespace App\Listeners;

use App\Events\UserCacheFlushEvent;
use Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCacheFlushListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(UserCacheFlushEvent $event): void
    {
        Cache::forget('users');
    }
}
