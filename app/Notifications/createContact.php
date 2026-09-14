<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class createContact extends Notification
{
    use Queueable;
    private $contact_id;
    private $email;
    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contact_id,$email,$message)
    {
        $this->contact_id = $contact_id;
        $this->email = $email;
        $this->message = $message;

    }


    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'contact_id' => $this->contact_id,
            'email' => $this->email,
            'message' => $this->message,
        ];
    }
}
