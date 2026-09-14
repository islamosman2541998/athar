<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WhatsAppContactResource;
use App\Models\WhatsAppContact;
use Illuminate\Http\Request;

class WhatsAppContactsController extends Controller
{
    public function index()
    {
        $data['whats_app_contact']  = new WhatsAppContactResource(WhatsAppContact::active()->feature()->first());
        $data['social_links'] = MULTIPLE_SETTING_SITE(['facebook', 'instagram', 'tiktok']);

        return $this->success($data , '' , 200 );
    }
}
