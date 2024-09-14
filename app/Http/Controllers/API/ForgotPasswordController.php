<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OTPNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email address'
            ]);
        }

        $otp = rand(1111, 9999);

        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(1);
        $user->save();

        $user->notify(new OTPNotification($otp));

        return response()->json([
            'status' => true,
            'message' => 'Your 4 digit OTP is ' . $otp
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|min:4'
        ]);
        $user = User::where('email', $request->email)->first();

        if ($user->otp == $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Your OTP is verified Successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP or Time Expirted'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:password'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->confirm_password);
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Password changed successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Mail id is invalid'
        ]);
    }
}
