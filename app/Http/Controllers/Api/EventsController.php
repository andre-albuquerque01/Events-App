<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckAdminToken;
use App\Http\Requests\StoreEventsRequest;
use App\Services\EventsService;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    protected $eventsService;

    public function __construct(EventsService $eventsService)
    {
        $this->eventsService = $eventsService;
        $this->middleware('auth:sanctum')->except(['index', 'show', 'showTitle']);
        $this->middleware(CheckAdminToken::class)->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        return $this->eventsService->index();
    }

    public function store(StoreEventsRequest $request)
    {
        return $this->eventsService->store($request->validated());
    }

    public function show(string $id)
    {
        return $this->eventsService->show($id);
    }

    public function showTitle(string $title)
    {
        return $this->eventsService->showTitle($title);
    }

    public function update(StoreEventsRequest $request, string $id)
    {
        return $this->eventsService->update($request->validated(), $id);
    }

    public function destroy(string $id)
    {
        return $this->eventsService->destroy($id);
    }
}
