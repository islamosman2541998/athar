<?php

namespace App\Http\Livewire\Site;

use App\Mail\BookingEmail;
use App\Models\Booking;
use App\Models\SettingsValues;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;


class DoctorBooking extends Component
{
    public $name, $email, $mobile, $date, $message, $specialty_id, $doctor_id;

    protected function rules() {
        return [
            'name'      => 'required|min:3',
            'specialty_id'  => 'required|numeric',
            'doctor_id'     => 'required|numeric',
            'email'     => 'nullable|email|min:3',
            'mobile'    => 'required|min:3|max:12',
            'date'      => 'required|date|after:now',
            'message'   => 'required|String|min:3',
        ];
    }

    public function sendForm(){
        $data = $this->validate();
        $booking = Booking::create($data);
        $data['specialty_name'] = $booking->specialty->trans()->where('locale', app()->getLocale())->first()->title;
        $data['doctor_name'] = $booking->doctor->trans()->where('locale', app()->getLocale())->first()->title;
        $email = @SettingsValues::where('key' , 'mail_booking')->first()->value ?? 'almarwa.wagdy@gmail.com';
        Mail::to($email)->send(new BookingEmail($data));
        session()->flash('success' , trans('message.site.contacted_confirm_appointment') );
        $this->clearForm();
    }

    public function clearForm(){
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
        $this->date = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.site.doctor-booking');
    }
}
