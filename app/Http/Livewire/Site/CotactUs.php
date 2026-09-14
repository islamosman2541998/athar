<?php

namespace App\Http\Livewire\Site;

use App\Models\User;
use Livewire\Component;
use App\Models\Services;
use App\Models\Contactus;
use App\Models\Portfolios;
use App\Notifications\createContact;
use Illuminate\Support\Facades\Notification;

class CotactUs extends Component
{
    public $name,  $email, $phone,  $message, $company;

    public function messages()
    {
        $attr = [];

        $attr += ['name' => __('contact_us.name') . trans('message.admin.required')];
        $attr += ['email' => __('contact_us.email')  . trans('message.admin.required')];
        $attr += ['company' => __('contact_us.company')  . trans('message.admin.required')];
        $attr += ['phone' => __('contact_us.phone')  . trans('message.admin.required')];
        $attr += ['message' => __('contact_us.message')  . trans('message.admin.required')];



        return $attr;
    }
    protected function rules()
    {
        return [
            'name'         => 'required',
            'email'        => 'nullable|email',
            'company'      => 'nullable',
            'phone'        => 'required',
            'message'      => 'required',
        ];
    }

    public function sendForm()
    {
        $data = $this->validate();
        $contact_us = Contactus::create($data);
        $users = User::all();
        Notification::send($users, new createContact($contact_us->id, $contact_us->email, $contact_us->message));
        session()->flash('success', trans('message.site.message_sucessfully'));
        $this->clearForm();
    }
    public function clearForm()
    {
        $this->name = '';
        $this->company = '';
        $this->phone = '';
        $this->email = '';
        $this->message = '';
    }
    public function render()
    {

        return view('livewire.site.cotact-us');
    }
}
