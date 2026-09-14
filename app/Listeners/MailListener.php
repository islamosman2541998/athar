<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Settings\SettingSingleton;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailListener implements  ShouldQueue
{
//    public $order;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(OrderEvent $event)
    {
        Log::info("Dispatching email job for Order ID: {$event->order->id}");

        // Dispatch email to the queue

        // Assuming you retrieve the order from the database
        Mail::to($event->order->customer_email)->queue(new OrderMail($event->order));
        Mail::to(SettingSingleton::getInstance()->getItem('email'))->queue(new OrderMail($event->order));
        Log::info("Email job dispatched for Order ID: {$event->order->id}");

    }
}
