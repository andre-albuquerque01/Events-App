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
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $events = Events::join('files', 'files.idFile', '=', 'events.idFile')->paginate();
            return new EventsResource($events);
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
        try {
            if ($request->hasFile('pathNameFile')) {
                $data = $request->validated();
                $pathName = $this->saveFile->saveImagem($request->pathName);
                $idFile = File::createGetId($pathName);
                $data['idFile'] = $idFile;
                Events::create($data);
                return response()->json(['message' => 'sucess'], 200);
            }
            return response()->json([['message' => 'Erro']], 400);
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
            $events = Events::findOrFail($id);
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
        try {
            $events = Events::findOrFail($id);
            $data = $request->validated();
            $pathName = $this->saveFile->saveImagem($request->pathName);
            $idFile = File::createGetId($pathName);
            $data['idFile'] = $idFile;
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
        try {
            Events::findOrFail($id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
