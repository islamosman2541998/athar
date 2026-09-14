<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppService;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
    public function showForm(Request $request)
    {
        return view('admin/dashboard/whatsapp/form');
    }

    public function send(Request $request)
    {
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        } catch (ConfigurationException $e) {
            dd($e . 'credentails no');
        }

        $message = $twilio->messages->create("whatsapp:" . $request->to, [
            'from' => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'),
            'body' => $request->message,
        ]);
        return $message;

    }


    /*************************************************/


//
//    public function handleIncomingMessage(Request $request)
//    {
//        $from = $request->input('From'); // The sender's number
//        $body = $request->input('Body'); // The message body
//
//        $from ='+201064612544';
//        $body = 'basmeya';
//
//        // Define your recipient numbers
//        $recipientNumbers = [
////            '+14155238886', // Add your first recipient's number
//            '+201064612544', // Add your second recipient's number
//            // Add more numbers as needed
//        ];
//
//        // Send the received message to the defined recipients
//        foreach ($recipientNumbers as $to) {
//            $this->sendMessage($to, $body);
//        }
//
//        return response()->json(['status' => 'Messages sent']);
//    }
//
//    private function sendMessage($to, $message)
//    {
//        $sid = env('TWILIO_SID');
//        $token = env('TWILIO_AUTH_TOKEN');
//        $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');
//
//        $client = new Client($sid, $token);
//        $client->messages->create(
//            "whatsapp:$to",
//            [
//                'from' => $twilioNumber,
//                'body' => $message,
//            ]
//        );
//    }
//
//
//
//


    public function handleAction(Request $request)
    {
        // Perform the customer action (e.g., saving data, processing a form, etc.)
        // Your action logic here...

        // Send WhatsApp message after the action is completed
        $this->sendWhatsAppMessage('+201064612544', 'A customer has completed an action.');

        return response()->json(['status' => 'Action completed and message sent.']);
    }




    private function sendWhatsAppMessage($to, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_NUMBER'); // Twilio WhatsApp number

        $client = new Client($sid, $token);
        $client->messages->create(
            "whatsapp:" . $to,
            [
                'from' => "whatsapp:".$twilioNumber,
                'body' => $message,
            ]
        );
    }

}
