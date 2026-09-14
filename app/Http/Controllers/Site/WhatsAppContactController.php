<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppContact;
use Illuminate\Http\Request;

class WhatsAppContactController extends Controller
{
    public function index()
    {
        $contacts = WhatsAppContact::active()
            ->with('transNow')   
            ->get();

        return view('site.pages.whatsapp', compact('contacts'));
    }
}
