<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function details(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Cannot get the user details. User is either logged out or token is invalid.'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'User details retrived',
            'data' => $user
        ]);
    }
}
