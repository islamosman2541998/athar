<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('site.auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'mobile'   => ['required','regex:/^01[0-9]{9}$/','exists:users,mobile'],
        ]);

        $user = User::where('mobile', $validated['mobile'])->first();

        if ($user && $user->status) {
            $otp = rand(100000, 999999);
            $user->activation_code = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();

            $this->sendOtpToWhatsApp($user->mobile, $otp);

            return redirect()->route('site.auth.verify.otp.login', ['user' => $user->id]);
        } else {
            return back()->withErrors(['mobile' => 'This mobile number is not registered or the account is inactive.']);
        }
    }

    public function showOtpLoginForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('site.auth.verify-otp-login', compact('user'));
    }

    public function verifyOtpLogin(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $otp = $request->input('otp');

        if ($user->activation_code == $otp && now()->lt($user->otp_expires_at)) {
            $user->activation_code = null;
            $user->otp_expires_at = null;
            $user->save();

            auth()->login($user);
            return redirect()->route('site.home');
        } else {
            return back()->withErrors(['otp' => 'otp not valid or expired']);
        }
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