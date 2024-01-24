<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Resources\EventsResource;
use App\Http\Services\SaveFile;
use App\Models\Events;
use App\Models\File;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    protected $saveFile;

    public function __construct(SaveFile $saveFile)
    {
        $this->saveFile = $saveFile;
        $this->middleware('auth:sanctum')->except(['index', 'show', 'showTitle']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $events = Events::join('files', 'files.idFile', '=', 'events.idFile')->paginate();
            return EventsResource::collection($events);
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
    public function store(StoreEventsRequest $request)
    {
        if (!auth()->user()->tokenCan("admin")) {
            return response()->json(['message' => "unauthorization"], 401);
        }
        try {
            if ($request->hasFile('pathName')) {
                $data = $request->all();
                $data['statusEvent'] = 1;
                $pathName = $this->saveFile->saveImagem($request->pathName);
                $idFile = File::insertGetId(
                    [
                        'pathName' => $pathName,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                $data['idFile'] = $idFile;
                Events::create($data);
                return response()->json(['message' => 'sucess'], 200);
            }
            return response()->json(['message' => 'bad request'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $events = Events::join('files', 'files.idFile', '=', 'events.idFile')->where('idEvents', $id)->first();
            return new EventsResource($events);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function showTitle(string $title)
    {
        try {
            $events = Events::join('files', 'files.idFile', '=', 'events.idFile')->where('title', $title)->first();
            return new EventsResource($events);
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
    public function update(StoreEventsRequest $request, string $id)
    {
        if (!auth()->user()->tokenCan("admin")) {
            return response()->json(['message' => "unauthorization"], 401);
        }
        try {
            $events = Events::findOrFail($id);
            $data = $request->all();
            if (isset($data['pathName'])) {
                $pathName = $this->saveFile->saveImagem($request->pathName);
                File::where('idFile', $events->idFile)->update(
                    [
                        'pathName' => $pathName,
                        'updated_at' => now(),
                    ]
                );
            }

            $events->update($data);
            return response()->json(['message' => 'sucess'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->tokenCan("admin")) {
            return response()->json(['message' => "unauthorization"], 401);
        }
        try {
            Events::findOrFail($id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
