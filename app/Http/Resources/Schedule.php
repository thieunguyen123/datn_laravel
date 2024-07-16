<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Schedule extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'badminton_court_id' => $this->badminton_court_id,
            'date' => $this->date,
            'empty_time' => json_decode($this->empty_time),
        ];
    }
}
