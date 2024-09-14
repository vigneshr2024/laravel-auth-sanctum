<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logged Out Successfully'
        ]);
    }
}
