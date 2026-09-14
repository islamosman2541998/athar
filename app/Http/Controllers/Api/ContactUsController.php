<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactUsRequest;
use App\Models\Contactus;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function store(ContactUsRequest $request)
    {
        $contact = Contactus::create($request->validated());
        if (!$contact) {
            return $this->error([], __('messages.failed'), 400);
        }
        return $this->success([], __('messages.success'), 201);

    }
}
