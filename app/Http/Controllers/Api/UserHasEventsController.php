<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\UserHasEventsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHasEventsController extends Controller
{
    private $userHasEventsService;

    public function __construct(UserHasEventsService $userHasEventsService)
    {
        $this->userHasEventsService = $userHasEventsService;
        $this->middleware('auth:sanctum')->only('showUserEvents', 'store', 'show', 'destroy', 'showEventsUser');
    }
    public function showUserEvents()
    {
        return $this->userHasEventsService->showUserEvents();
    }

    public function showEventsUser(string $id)
    {
        return $this->userHasEventsService->showEventsUser($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idEvents' => 'required'
        ]);
        return $this->userHasEventsService->store($request->idEvents);
    }

    public function show(string $id)
    {
        return $this->userHasEventsService->show($id);
    }

    public function destroy(string $id)
    {
        return $this->userHasEventsService->destroy($id);
    }
}
