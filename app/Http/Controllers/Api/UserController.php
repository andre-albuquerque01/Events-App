<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\RecoverPassword;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('store', 'verifyEmail', 'sendTokenRecoverPassword', 'verifyTokenRecover');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::paginate();
            return UserResource::collection($users);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Verify e-mail
     */
    public function verifyEmail(string $email)
    {
        try {
            User::where('email', Crypt::decryptString($email))->update([
                'email_verified_at' => now()
            ]);
            return response()->json(['message' => 'E-mail verificado'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($request->password);
            $data['role'] = 'user';
            $user = User::create($data);
            Mail::to($request->email)->send(new VerifyEmail([
                'toEmail' => $request->email,
                'subject' => 'Verificar e-mail',
                'message' =>  Crypt::encryptString($request->email)
            ]));
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->validated();
            if (bcrypt($request->password) == $user->password) {
                $data['password'] = bcrypt($request->password);
                $user->update($data);
                return new UserResource($user);
            }
            return response()->json(['message' => 'error'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(StoreUserRequest $request, string $token)
    {
        try {
            $decriptToken = Crypt::decryptString($token);
            $check = DB::table('password_reset_tokens')->where('token', $decriptToken)->first();
            if ($check) {
                User::where('email', $check->email)->update([
                    'password' => bcrypt($request->password)
                ]);
                return response()->json(['message' => 'sucess'], 200);
            } else {
                return response()->json(['message' => 'Error, token invalido'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /** 
     * Send token
     */
    public function sendTokenRecoverPassword(Request $request)
    {
        try {
            if (User::where('email', $request->email)->first()) {
                $token = Str::random(6);
                DB::table('password_reset_tokens')->create([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now()
                ]);

                Mail::to($request->email)->send(new RecoverPassword([
                    'toEmail' => $request->email,
                    'subject' => 'Redefinir senha',
                    'message' => $token,
                    'expiration_hours' => "10 minutos"
                ]));

                return response()->json(['message' => 'send e-mail'], 200);
            }
            return response()->json(['message' => 'E-mail desconhecido'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /**  
     * Verificar o token
     */
    public function verifyTokenRecover(Request $request)
    {
        try {
            $token = DB::table('password_reset_tokens')->where('token', $request->token)->first();
            if ($token) {
                $expiration = $token->created_at->addMinutes(10);
                if (now()->greaterThanOrEqualTo($expiration)) {
                    return response()->json(['message' => 'Error, token expirou'], 400);
                } else {
                    $tokenCript = Crypt::encryptString($request->token);
                    return response()->json(['token' => $tokenCript], 200);
                }
            } else {
                return response()->json(['message' => 'Error, token invalido'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::findOrFail($id)->delete();
            return response()->json([], HttpResponse::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}
