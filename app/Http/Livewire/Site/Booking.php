<?php

namespace App\Http\Livewire\Site;

use App\Mail\BookingEmail;
use App\Models\Booking as ModelsBooking;
use App\Models\Doctor;
use App\Models\SettingsValues;
use App\Models\Specialties;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class Booking extends Component
{
    public $specialties = [], $doctors = [];

    public $name, $email, $mobile, $date, $message, $specialty_id, $doctor_id;


    public function mount(){
        $this->specialties = Specialties::with('trans')->orderBy('sort', 'ASC')->active()->get();
    }

    protected function rules() {
        return [
            'name'          => 'required|min:3',
            'specialty_id'  => 'required|numeric',
            'doctor_id'     => 'required|numeric',
            'email'         => 'nullable|email|min:3',
            'mobile'        => 'required|min:3|max:12',
            'date'          => 'required|date|after:now',
            'message'       => 'required|String|min:3',
        ];
    }

    public function sendForm(){
        $data = $this->validate();
        $booking = ModelsBooking::create($data);

        $data['specialty_name'] = $booking->specialty->trans()->where('locale', app()->getLocale())->first()->title;
        $data['doctor_name'] = $booking->doctor->trans()->where('locale', app()->getLocale())->first()->title;

        $email = @SettingsValues::where('key' , 'mail_booking')->first()->value ?? 'almarwa.wagdy@gmail.com';
        Mail::to($email)->send(new BookingEmail($data));

        session()->flash('success' , trans('message.site.contacted_confirm_appointment') );
        $this->clearForm();
    }

    public function updatedSpecialtyId($specialty_id){
       $this->doctors = Doctor::with('trans')->where('specialty_id', $specialty_id)->orderBy('sort', 'ASC')->active()->get();
    }

    public function clearForm(){
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
        $this->date = '';
        $this->specialty_id = '';
        $this->doctor_id = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.site.booking');
    }
}
