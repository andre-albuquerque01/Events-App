<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserHasEventRequest;
use App\Http\Resources\EventsResource;
use App\Models\UserHasEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $event = UserHasEvents::join('users', 'users.idUser', '=', 'user_has_events.idUser')->join('events', 'events.idEvents', '=', 'user_has_events.idEvents');/*->where('users.idUser', '=', 'user_has_events.idUser');*/
        return new EventsResource($event);
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
        $data = $request->validated();
        $user = Auth::user();
        $data['idUser'] = $user;
        $event = UserHasEvents::create($data);
        return new EventsResource($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
