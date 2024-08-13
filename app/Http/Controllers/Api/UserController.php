<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecoverPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:sanctum')->only('index','show', 'update', 'destroy');
    }

    public function index()
    {
        return $this->userService->index();
    }

    public function verifyEmail(string $email)
    {
        return $this->userService->verifyEmail($email);
    }

    public function store(StoreUserRequest $request)
    {
        return $this->userService->store($request->validated());
    }

    public function show(string $id)
    {
        return $this->userService->show($id);
    }

    public function reSendToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        return $this->userService->reSendToken($request->email);
    }

    public function update(StoreUserRequest $request)
    {
        return $this->userService->update($request->validated());
    }

    public function destroy(string $id)
    {
        return $this->userService->destroy($id);
    }

    public function sendTokenRecover(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        return $this->userService->sendTokenRecover($request->email);
    }

    public function resetPassword(RecoverPasswordRequest $request)
    {
        return $this->userService->resetPassword($request->validated());
    }
}
