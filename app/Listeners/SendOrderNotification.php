<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewOrderNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Add this import

class SendOrderNotification implements ShouldQueue // Implement ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreated $event)
    {
        try {
            dd("mal");
            Mail::to('islamosman2541998@gmail.com')->send(
                new NewOrderNotification($event->order)
            );
        } catch (\Exception $e) {
            Log::error('Mail sending failed: '.$e->getMessage());
            // Consider adding retry logic here
        }
    }
}