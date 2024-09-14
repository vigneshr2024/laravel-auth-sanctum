<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credentials'
            ]);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth');
        return response()->json([
            'status' => true,
            'message' => 'User logged successfully',
            'token' => $token->plainTextToken
        ]);
    }
}
