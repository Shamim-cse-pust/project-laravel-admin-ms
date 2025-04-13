<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdminListener
{
    public function handle(OrderCompletedEvent $event): void
    {
        Mail::send('influencer.admin', ['order' => $event->order], function ($message) {
            $message->to('admin@gmail.com');
            $message->subject('A new order has been completed');
        });
    }
}
