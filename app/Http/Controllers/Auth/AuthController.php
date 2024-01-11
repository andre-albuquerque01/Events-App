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
            $user = Auth::user();
            $scopes = ($user->role == "admin") ? ['admin'] : ['user'];
            $token = $request->user()->createToken('user', $scopes, now()->addHours(2))->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user->idUser], 200);
        }
        return response()->json(['message' => 'unauthorization'], 403);
    }

    public function logout(Request $request)
    {
    }
}
