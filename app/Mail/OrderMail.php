<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order; // Add a property to hold order data

    /**
     * Create a new message instance.
     *
     * @param mixed $order // Pass order data into the constructor
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order; // Assign the order data
    }
    public function build()
    {
        try{
            return $this->from(env('MAIL_FROM_ADDRESS'), 'Mailtrap')
                ->subject('Welcome To basma website')
                ->markdown('admin.emails.order') //View to send
                ->with([
                    'order' => $this->order,
                ]);

        }
        catch(\Exception $e){

        }
    }
//     public function envelope()
//    {
//        return new Envelope(
//            subject: 'Order Mail',
//        );
//    }

//     public function content()
//    {
//        return new Content(
//            view: 'admin.emails.order', // Update to your desired view
//            with: [
//        'order' => $this->order, // Pass order data to the view
//    ],
//        );
//    }
//
//     public function attachments()
//    {
//        return []; // You can add attachments here if needed
//    }
}
