<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserHasEventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'idHasEvents' => $this->idUser_has_events, 
            'event' => new EventsResource($this->whenLoaded('events')),
            'users' => new UserResource($this->whenLoaded('user')),
            'created' => Carbon::make($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
