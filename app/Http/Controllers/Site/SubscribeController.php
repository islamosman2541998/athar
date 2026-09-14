<?php

namespace App\Http\Controllers\Site;

use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribes,email',
        ]);


        try {
            Subscribe::create([
                'email' => $request->email,
            ]);

            return redirect()->back()->with('success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error');
        }
    }
}
