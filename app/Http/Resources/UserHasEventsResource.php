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
            'id' => $this->idEvents,
            'title' => $this->title,
            'price' => $this->price,
            'statusEvent' => $this->statusEvent,
            'pathName' => $this->pathName,
            'created' => Carbon::make($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
