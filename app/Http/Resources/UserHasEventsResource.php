<?php

namespace App\Http\Resources;

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
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'title' => $this->title,
        //     'departament' => $this->departament,
        //     'occupation' => $this->occupation,
        //     'created' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        // ];
    }
}
