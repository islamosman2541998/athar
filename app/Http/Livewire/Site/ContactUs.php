<?php

namespace App\Http\Livewire\Site;

use App\Mail\ContactEmail;
use App\Models\Contactus as ModelsContactus;
use App\Models\SettingsValues;
use App\Models\User;
use App\Notifications\createContact;
use App\Settings\SettingSingleton;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use PHPMailer\PHPMailer\PHPMailer;

class ContactUs extends Component
{
    public $name,  $email, $phone,  $message;

    protected function rules() {
        return [
            'name'          => 'required|min:3',
            'email'         => 'nullable|email|min:3',
            'phone'        => 'required|min:3|max:12',
            'message'       => 'required|String|min:3',
        ];
    }

    public function sendForm()
    {
        $data = $this->validate();
        $contact_us = ModelsContactus::create($data);
        $users = User::all();
        // send notification to admin
        Notification::send($users, new createContact($contact_us->id, $contact_us->email, $contact_us->message));
        // send email notification
        try {
            $settings  = SettingSingleton::getInstance();
            $email = $settings->getItem('mail_booking')?? 'almarwa.wagdy@gmail.com';

            $send = Mail::to($email)->send(new ContactEmail($data));
            // $this->sendMail();
        } catch (\Exception $e) {
        }
        session()->flash('success', trans('message.site.message_sucessfully'));
        $this->clearForm();
    }


    public function sendMail (){
        $email = @SettingsValues::where('key' , 'mail_booking')->first()->value ?? 'almarwa.wagdy@gmail.com';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'almanarclinics.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@almanarclinics.com';
        $mail->Password = '2CJt9o!v$$Gw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 465;
        $mail->setFrom('contact@almanarclinics.com', 'Almanar clinics');
        $mail->addAddress($email);
        $mail->Subject = 'Contact Email Almanar';
        $mail->Body = 'This is a test email using PHPMailer.';
        if (!$mail->send()) {
            dd("faild");
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
            dd("sucessfully sent");
        }
    }


    public function clearForm()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.site.contact-us');
    }
}
