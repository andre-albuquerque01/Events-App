<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $userAut = User::where('email', $request->email)->first();
            if (!$userAut) {
                return response()->json(['message' => 'Usuário não encontrado'], 400);
            }
            if ($userAut->email_verified_at == null) {
                return response()->json(['message' => 'E-mail não verificado'], 400);
            }
            if (Auth::attempt($request->only("email", "password"))) {
                $user = Auth::user();
                $scopes = ($user->role == "admin") ? ['admin'] : ['user'];
                $token = $request->user()->createToken('user', $scopes, now()->addHours(2))->plainTextToken;
                return new AuthResource(['idUser' => $user->idUser, 'token' => $token]);
            }
            return response()->json(['message' => 'unauthorization'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'sucess logout'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
