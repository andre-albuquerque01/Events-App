<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'idUser' => $this->idUser,
            'name' => $this->name,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'updated' => Carbon::make($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
