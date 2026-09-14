<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateShippingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    protected  $order;
    /**
     * Create a new message instance.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order; // Assign the order data
    }



    public function build()
    {
        try {
            return $this->from(env('MAIL_FROM_ADDRESS'), 'Mailtrap')
                ->subject('Your Order Shipping Status is changed')
                ->markdown('admin.emails.order_shipping_status') //View to send
                ->with([
                    'order' => $this->order,
                ]);
        }
        catch(\Exception $e){

        }

    }


}
