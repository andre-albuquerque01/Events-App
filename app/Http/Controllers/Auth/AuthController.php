<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only("email", "password"))) {
            $token = $request->user()->createToken('', ['*'], now()->addHours(2))->plainTextToken;
            $user = Auth::user();
            return response()->json(['token' => $token, 'user' => $user->id], 200);;
        }
        // return response()->json([''],403);
    }

    public function logout(Request $request)
    {
    }
}
