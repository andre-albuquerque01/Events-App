<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\GeneralExceptionCatch;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Http\Resources\GeneralResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function login(Request $request)
    {
        try {
            $userAut = User::where('email', $request->email)->first();
            if (!$userAut) {
                return new GeneralResource(['message' => 'Usuário ou senha invalida']);
            }
            if ($userAut->email_verified_at == null) {
                return new GeneralResource(['message' => 'E-mail não verificado']);
            }
            if (Auth::attempt($request->only("email", "password"))) {
                $user = Auth::user();
                $scopes = ($user->role == "admin") ? ['admin'] : ['user'];
                $token = $request->user()->createToken('user', $scopes, now()->addHours(2))->plainTextToken;
                if ($user->role == 'admin') $role = 'JesusIsKingADM';
                else $role = 'u';
                return new AuthResource(['idUser' => $user->idUser, 'token' => $token, 'r' => $role]);
            }
            return new GeneralResource(['message' => 'unauthorization']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, login', 400);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return new GeneralResource(['message' => 'sucess logout']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, logout', 400);
        }
    }
}
