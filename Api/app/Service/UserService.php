<?php

namespace App\Service;

use App\Exceptions\GeneralExceptionCatch;
use App\Exceptions\UserException;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\UserResource;
use App\Jobs\SendRecoverPasswordEmailJob;
use App\Jobs\SendVerifyEmailJob;
use App\Mail\RecoverPassword;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{

    public function index()
    {
        try {
            $users = User::paginate();
            return UserResource::collection($users);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, index', 400);
        }
    }

    public function verifyEmail(string $email)
    {
        try {
            User::where('email', Crypt::decryptString($email))->touch('email_verified_at');
            return new GeneralResource(['message' => 'E-mail verificado']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, verify email', 400);
        }
    }

    public function store(array $data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $data['role'] = 'user';
            User::create($data);

            dispatch(new SendVerifyEmailJob($data['email']));

            return new GeneralResource(['message' => 'success']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, store', 400);
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return new UserResource($user);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, show user', 400);
        }
    }

    public function reSendToken(string $email)
    {
        try {
            User::findOrFail($email, 'email');
            dispatch(new SendVerifyEmailJob($email));
            return new GeneralResource(['message' => 'E-mail went send']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, resend token', 400);
        }
    }

    public function update(array $data)
    {
        try {
            if (!Hash::check($data['password'], auth()->user()->password)) {
                return new GeneralResource(['error' => 'error']);
            }
            $data['password'] = Hash::make($data['password']);
            User::where('idUser', auth()->user()->idUser)->update($data);
            return new GeneralResource(['message' => 'success']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, update', 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            User::findOrFail($id)->delete();
            return new GeneralResource(['message' => 'success']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, delete', 400);
        }
    }

    public function sendTokenRecover(string $email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) throw new UserException('user not found');

            $token = strtoupper(Str::random(60));
            $table = DB::table('password_reset_tokens')->where('email', $email)->first();
            if (!$table) {
                DB::table('password_reset_tokens')->insert([
                    'email' => $email,
                    'token' => $token,
                    'created_at' => now(),
                ]);
            } else {
                DB::table('password_reset_tokens')->update([
                    'token' => $token,
                    'created_at' => now(),
                ]);
            }
            dispatch(new SendRecoverPasswordEmailJob($user->email, $token));
            return new GeneralResource(['message' => 'send e-mail']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch($e->getMessage());
        }
    }
    public function resetPassword(array $data)
    {
        try {
            $passwordResetTokens = DB::table('password_reset_tokens')->where('token', $data['token'])->first();
            if (!isset($passwordResetTokens)) throw new UserException("Token invalid");

            User::where('email', $passwordResetTokens->email)->update([
                'password' => Hash::make($data['password']),
            ]);
            DB::table('password_reset_tokens')->where('token', $data['token'])->delete();
            return new GeneralResource(['message' => 'success']);
        } catch (\Exception $e) {
            throw new UserException('', $e->getCode(), $e);
        }
    }
}
