<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Order;

class ProfileController extends Controller
{
    public function __construct()
    {
        // auth()->logout();
        // $user = User::where('email', 'giminawyn@mailinator.com')->first();
        // if ($user) {
        //     auth()->login($user);
        // }
        // $this->middleware('auth');
    }

    public function show()
    {

        $user = Auth::user();
        return view('site.pages.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('site.pages.profile.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();
    
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'mobile' => ['required', 'regex:/^01[0-9]{9}$/', 'unique:users,mobile,' . $user->id],
        ]);
    
        $user->update($data);
    
         return redirect()->route('site.profile.show')->with('success', __('messages.profile_updated'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = $user->orders()->with([
            'orderDetails.product',
            'orderStatus',
            'shippingOrderStatus',
            'receipentsDetails',
            'deliveryDetails',
            'extraOrderDetails',
            
        ])->latest()->paginate(10);
        return view('site.pages.profile.orders', compact('orders'));
    }
}