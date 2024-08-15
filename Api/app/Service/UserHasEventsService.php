<?php

namespace App\Service;

use App\Exceptions\GeneralExceptionCatch;
use App\Http\Resources\GeneralResource;
use App\Http\Resources\UserHasEventsResource;
use App\Http\Resources\UserIsEventsResource;
use App\Models\Events;
use App\Models\UserHasEvents;

class UserHasEventsService
{
    public function showUserEvents()
    {
        try {
            $user = auth()->user();
            $event = UserHasEvents::with(['events'])->where('user_has_events.idUser', '=', $user->idUser)->paginate();
            return UserHasEventsResource::collection($event);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, showUserEvents', 400);
        }
    }

    public function showEventsUser(string $idEvents)
    {
        try {
            $event = UserHasEvents::with(['user', 'events'])->where('user_has_events.idEvents', $idEvents)->paginate();
            return UserHasEventsResource::collection($event);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, showEventsUser', 400);
        }
    }

    public function store(string $idEvents)
    {
        try {
            $user = auth()->user();
            $data['idUser'] = $user->idUser;
            $data['idEvents'] = $idEvents;

            if (UserHasEvents::where('idUser', $user->idUser)->where('idEvents',  $data['idEvents'])->exists()) {
                return new GeneralResource(['message' => 'Erro, já participando do mesmo evento']);
            }

            $ret = Events::where('idEvents',  $data['idEvents'])->first();

            $upOcupp = Events::where('idEvents', '=',  $data['idEvents'])->where('occupation', '>', 0)->update(
                [
                    'occupation' => $ret->occupation - 1,
                ]
            );

            if ($upOcupp) {
                UserHasEvents::create($data);
                return new GeneralResource(['message' => 'Cadastro realizado com sucesso']);
            } else {
                return new GeneralResource(['message' => 'Evento com o máximo de ocupação']);
            }
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, create', 400);
        }
    }

    public function show(string $id)
    {
        try {
            $event = UserHasEvents::with(['user', 'events'])->find($id);
            return new UserHasEventsResource($event);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, show', 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            UserHasEvents::findOrFail($id)->delete();
            return new GeneralResource(['message' => 'sucess']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, destroy', 400);
        }
    }
}
