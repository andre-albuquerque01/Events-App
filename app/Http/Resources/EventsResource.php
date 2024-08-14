<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'idEvents' => $this->idEvents,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'department' => $this->department,
            'occupation' => $this->occupation,
            'qtdParcelamento' => $this->qtdParcelamento,
            'dateEvent' => $this->dateEvent,
            'timeEvent' => $this->timeEvent,
            'statusEvent' => $this->statusEvent,
            'pathName' => $this->pathName,
            'updated' => Carbon::make($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
