<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserHasEventRequest;
use App\Http\Resources\UserHasEventsResource;
use App\Http\Services\SaveFile;
use App\Models\UserHasEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasEventsController extends Controller
{
    protected $saveFile;

    public function __construct(SaveFile $saveFile)
    {
        $this->saveFile = $saveFile;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $event = UserHasEvents::join('users', 'users.idUser', '=', 'user_has_events.idUser')->join('events', 'events.idEvents', '=', 'user_has_events.idEvents')->where('users.idUser', '=', 'user_has_events.idUser')->paginate();
            return new UserHasEventsResource($event);
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
    public function store(StoreUserHasEventRequest $request)
    {
        try {
            if ($request->hasFile('pathName')) {
                // $user = Auth::user()->id;
                $user = 1;
                $data = $request->all();
                $pathName = $this->saveFile->saveImagem($request->pathName);
                $data['pathName'] = $pathName;
                $data['idUser'] = $user;
                UserHasEvents::create($data);
                return response()->json([['message' => 'sucess']], 200);
            }
            return response()->json([['message' => 'Erro']], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $event = UserHasEvents::find($id);
            return new UserHasEventsResource($event);
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
    public function update(StoreUserHasEventRequest $request, string $id)
    {
        try {
            $data = $request->all();
            if (isset($request->pathName)) {
                $image = $this->saveFile->saveImagem($request->pathName);
                $data['pathName'] = $image;
            }
            UserHasEvents::where('idUser_has_events', $id)->update($data);
            return response()->json(['message' => 'sucess'], 200);
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
            UserHasEvents::findOrFail($id)->delete();
            return response()->json(['message' => 'sucess'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}
