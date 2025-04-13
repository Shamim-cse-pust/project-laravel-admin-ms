<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyInfluencerListener
{
    public function handle(OrderCompletedEvent $event): void
    {
        Mail::send('influencer.influencer', ['order' => $event->order], function ($message) use ($event) {
            $message->to($event->order->influencer_email);
            $message->subject('Your order has been confirmed');
        });
    }
}
