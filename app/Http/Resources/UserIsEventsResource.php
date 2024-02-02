<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserIsEventsResource extends JsonResource
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
            'idEvents' => $this->idEvents,
            'title' => $this->title,
            'name' => $this->name,
        ];
    }
}
