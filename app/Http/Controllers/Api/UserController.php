<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response as HttpResponse;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('store');
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
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($request->password);
            $data['role'] = 'user';
            $user = User::create($data);

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
