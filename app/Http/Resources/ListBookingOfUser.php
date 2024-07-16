<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AllCode;

class ListBookingOfUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status_id' => $this->getValueKeyMap($this->resource['status_id']),
            'time_booking_start' => $this->getValueOfTimeBooking($this->resource['time_booking']),
            'day_booking' => $this->resource['day_booking'],
        ];
    }

    protected function getValueKeyMap($keyMap)
    {
        $value =  AllCode::where('key_map', $keyMap)->first();
        return optional($value)->value;
    }

    protected function getValueOfTimeBooking($keyMap)
    {
        $value = AllCode::where('key_map',$keyMap)->first();
        return optional($value)->value;
    }
}
