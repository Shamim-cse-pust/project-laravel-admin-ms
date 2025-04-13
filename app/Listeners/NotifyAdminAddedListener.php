<?php

namespace App\Listeners;

use App\Events\AdminAddedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminAddedListener
{
    public function handle(AdminAddedEvent $event): void
    {
        Mail::send('admin.adminAdded', ['user' => $event->user], function ($message) use ($event) {
            $message->to($event->user->email);
            $message->subject('You are Registered User Now');
        });
    }
}
