<?php

namespace App\Service;

use App\Exceptions\GeneralExceptionCatch;
use App\Http\Resources\EventsResource;
use App\Http\Resources\EventsTitleResource;
use App\Http\Resources\GeneralResource;
use App\Models\Events;
use App\Models\File;

class EventsService
{
    public function index()
    {
        try {
            $events = Events::where('statusEvent',  1)->paginate();
            return EventsResource::collection($events);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, index', 400);
        }
    }

    public function store(array $data)
    {
        try {
            $data['statusEvent'] = 1;
            Events::create($data);
            return new GeneralResource(['message' => 'success']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, store', 400);
        }
    }

    public function show(string $id)
    {
        try {
            $events = Events::where('idEvents', $id)->first();
            return new EventsResource($events);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, store', 400);
        }
    }

    public function showTitle(string $title)
    {
        try {
            $events = Events::where('title', 'LIKE', '%' . $title . '%')->get();
            return new EventsResource($events);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, store', 400);
        }
    }

    public function update(array $data, string $id)
    {
        try {
            $events = Events::findOrFail($id);

            $events->update($data);
            return new GeneralResource(['message' => 'success']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, store', 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            Events::findOrFail($id)->delete();
            return new GeneralResource(['message' => 'success']);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error, store', 400);
        }
    }
}
