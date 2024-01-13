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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('store', 'verifyEmail');
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
            if ($request->password)
                $data['password'] = bcrypt($request->password);
            $user->update($data);
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function verifyPassword(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();
            if ($user !== null) {
                $newPassword = Str::random(8);

                $user->password = bcrypt($newPassword);
                $user->save();

                Mail::to($user->email)->send(new RecoverPassword([
                    'toEmail' => $email,
                    'subject' => 'Redefinir senha',
                    'message' => $newPassword
                ]));
                return response()->json(['message' => 'send e-mail'], 200);
            }
            return response()->json(['message' => 'not send e-mail'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user !== null) {
                User::where('email', $request->email)->update([
                    'password' => bcrypt($request->password)
                ]);
                return response()->json(['message' => 'Senha alterada'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
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
