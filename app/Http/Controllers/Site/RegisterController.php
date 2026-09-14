<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('site.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => ['required','regex:/^01[0-9]{9}$/','unique:users,mobile'],
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'password' => Hash::make($validated['password']),
        ]);

        $otp = rand(100000, 999999);
        $user->activation_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        $this->sendOtpToWhatsApp($user->mobile, $otp);

        return redirect()->route('site.auth.verify.otp', ['user' => $user->id]);
    }

    public function showOtpForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('site.auth.verify-otp', compact('user'));
    }

    public function verifyOtp(Request $request, $userId)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);
    
        $user = User::findOrFail($userId);
    
        if ($user->activation_code === $request->otp 
            && now()->lt($user->otp_expires_at)) {
    
            $user->update([
                'status'       => true,
                'activation_code' => null,
                'otp_expires_at'  => null,
            ]);
    
            auth()->login($user);
    
            return redirect()->route('site.home');
        }
    
        return back()->withErrors([
            'otp' => 'The OTP is invalid or has expired.',
        ]);
    }
    

    protected function sendOtpToWhatsApp($mobile, $otp)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');
    
        $countryCode = '+20';
        $mobileWithoutZero = substr($mobile, 1); 
        $internationalNumber = $countryCode . $mobileWithoutZero;
    
        $client = new Client($sid, $token);
        $client->messages->create(
            "whatsapp:{$internationalNumber}",
            [
                'from' => "whatsapp:{$twilioNumber}",
                'body' => " An OTP has been sent to you. OTP:    {$otp}"
            ]
        );
    }
}