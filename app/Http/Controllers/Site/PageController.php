<?php

namespace App\Http\Controllers\Site;

use App\Models\Pages;
use App\Models\Contactus;
use App\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Settings\HomeSettingSingleton;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function show(string $id)
    {   
        if (is_numeric($id)) {
            $page = Pages::findOrFail($id);
            $page_name = $page->trans->first()->slug ?? 'page'; 
        } else {
            $page = Pages::with('trans')->WhereTranslation('slug', $id)->get()->first();
            if ($page == null) abort('404');
            $page_name = $id; 
        }

        $settings = SettingSingleton::getInstance();
        $current_lang = app()->getLocale();

        return view('site.pages.page', compact('page', 'settings', 'current_lang', 'page_name')); 
    }

    public function index()
    {

        $settings = SettingSingleton::getInstance();
        $current_lang = app()->getLocale();
        return view('site.pages.contactus', compact('settings', 'current_lang'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'city'    => 'nullable|string|max:255',
            'type'    => 'nullable|string|max:100',
        ]);

        Contactus::create(array_merge($data, [
            'status'     => 'new',
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]));

        return redirect()->back()
                         ->with('success', 'Your message has been sent. We will contact you soon!');
    }

    public function contactUs()
    {   
        $contactUs = HomeSettingSingleton::getInstance()->getItem('contact-us');
        $settings = SettingSingleton::getInstance();
        $current_lang = app()->getLocale();
        $page_name = 'contact';

        return view('site.pages.contactus', compact('contactUs', 'settings', 'current_lang', 'page_name')); 
    }
}