<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderNotification extends Mailable {

    use Queueable, SerializesModels;

    public $order;
    
    public function __construct($order) {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            subject:"new Order #" . $this->order->id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            markdown: 'emails.new_order',
            with:[
                'message' => "test message",
            ]
        );
    }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
    // public function build() {
    //     return $this->subject('طلب جديد #' . $this->order->id)
    //                 ->view('site.pages.emails.new_order');
    // }
}