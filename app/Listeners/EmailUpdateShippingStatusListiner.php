<?php

namespace App\Listeners;

use App\Events\UpdateShippingStatusEvent;
use App\Mail\OrderMail;
use App\Mail\UpdateShippingStatusMail;
use App\Settings\SettingSingleton;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailUpdateShippingStatusListiner implements ShouldQueue
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
     * @param  \App\Events\UpdateShippingStatusEvent  $event
     * @return void
     */
    public function handle(UpdateShippingStatusEvent $event)
    {
        Log::info("Dispatching email job for Order ID: {$event->order->id}");

        Mail::to($event->order->customer_email)->queue(new UpdateShippingStatusMail($event->order));
        Mail::to(SettingSingleton::getInstance()->getItem('email'))->queue(new UpdateShippingStatusMail($event->order));
        Log::info("Email job dispatched for Order ID: {$event->order->id}");

    }
}
