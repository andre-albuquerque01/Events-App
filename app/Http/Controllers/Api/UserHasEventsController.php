<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserHasEventRequest;
use App\Http\Resources\UserHasEventsResource;
use App\Http\Resources\UserIsEventsResource;
use App\Http\Services\SaveFile;
use App\Models\Events;
use App\Models\User;
use App\Models\UserHasEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasEventsController extends Controller
{
    protected $saveFile;

    public function __construct(SaveFile $saveFile)
    {
        $this->saveFile = $saveFile;
        // $this->middleware('auth:sanctum')->only('showUserEvents', 'store', 'show', 'update', 'destroy', 'showEventsUser');
    }
    /**
     * Display a listing of the resource.
     */

    public function showUserEvents()
    {
        try {
            $user = Auth::user();
            $event = UserHasEvents::join('users', 'users.idUser', '=', 'user_has_events.idUser')->join('events', 'events.idEvents', '=', 'user_has_events.idEvents')->join('files', 'events.idFile', '=', 'files.idFile')->where('user_has_events.idUser', '=', $user->idUser)->paginate();
            return UserHasEventsResource::collection($event);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function showEventsUser(int $idEvents)
    {
        try {
            $event = UserHasEvents::join('users', 'users.idUser', '=', 'user_has_events.idUser')->join('events', 'events.idEvents', '=', 'user_has_events.idEvents')->where('user_has_events.idEvents', '=', $idEvents)->paginate();
            return UserIsEventsResource::collection($event);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $data['idUser'] = $user->idUser;
            $data['idEvents'] = $request->idEvents;

            $userExists = User::find($user->idUser);
            if (!$userExists) {
                throw new \Exception("Usuário não encontrado");
            }

            if (UserHasEvents::where('idUser', $user->idUser)->where('idEvents', $request->idEvents)->exists()) {
                return response()->json(['message' => 'Erro, já participando do mesmo evento'], 400);
            }

            $ret = Events::where('idEvents', $request->idEvents)->first();

            $upOcupp = Events::where('idEvents', '=', $request->idEvents)->where('occupation', '>', 0)->update(
                [
                    'occupation' => $ret->occupation - 1,
                ]
            );

            if ($upOcupp) {
                UserHasEvents::create($data);
                return response()->json(['message' => 'Cadastro realizado com sucesso'], 200);
            } else {
                return response()->json(['message' => 'Evento com o máximo de ocupação'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
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
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserHasEventRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            if (isset($request->pathName)) {
                // $image = $this->saveFile->saveImagem($request->pathName);
                $data['pathName'] = $request->pathName;
            }
            UserHasEvents::where('idUser_has_events', $id)->update($data);
            return response()->json(['message' => 'sucess'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
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
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
