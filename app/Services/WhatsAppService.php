<?php


// app/Services/WhatsAppService.php

namespace App\Services;

use App\Models\Order;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;


class WhatsAppService
{
//    protected $client;
//
//    public function __construct()
//    {
//        try {
//            $this->client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
//        } catch (ConfigurationException $e) {
//            echo $e->getCode();
//        }
//    }
//
//    public function sendMessage($to, $message)
//    {
//        return $this->client->messages->create(
//            "whatsapp:$to",
//            [
//                'from' => env('TWILIO_WHATSAPP_NUMBER'),
//                'body' => $message,
//            ]
//        );
//    }
//


//    protected $client;
//
//    public function __construct()
//    {
//        try {
//            $this->client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
//        } catch (ConfigurationException $e) {
//            echo $e->getCode();
//        }
//    }
//
//    public function sendMessage($to, $message)
//    {
//        return $this->client->messages->create(
//            "whatsapp:$to",
//            [
//                'from' => env('TWILIO_WHATSAPP_NUMBER'),
//                'body' => $message,
//            ]
//        );
//    }
//


    public function handleAction(Order $order)
    {
        // Perform the customer action (e.g., saving data, processing a form, etc.)
        // Your action logic here...

        // Send WhatsApp message after the action is completed
        $message = "A customer has completed an order right  " . "   " . "order : " . $order->identifier . "   " . " customer name : " . $order->customer_name . "   " . "   at : " . $order->created_at;

        $this->sendWhatsAppMessage(env('TWILIO_WHATSAPP_ADMIN_NUMBER') ?? '+201064612544', $message);

        return response()->json(['status' => 'Action completed and message sent.']);
    }

    private function sendWhatsAppMessage($to, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_NUMBER'); // Twilio WhatsApp number

        try {
            $client = new Client($sid, $token);
            $client->messages->create(
                "whatsapp:" . $to,
                [
                    'from' => "whatsapp:" . $twilioNumber,
                    'body' => $message,
                ]
            );

        } catch (ConfigurationException $e) {
        }
    }


}
