<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\WhatsAppService;

class WhatsappListener
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
     * @param object $event
     * @return void
     */
    public function handle(OrderEvent $event)
    {
        $m = new   WhatsAppService();
        return $m->handleAction($event->order);

    }
}
