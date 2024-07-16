<?php

namespace App\Http\Resources;

use App\Models\AllCode;
use App\Models\BadmintonCourt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Booking extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['key'],
            'badminton_court' => $this->getNameBadmintonCourt($this->resource['badminton_court_id']),
            'badminton_court_id' => $this->resource['badminton_court_id'],
            'status_id' => $this->getValueKeyMap($this->resource['status_id']),
            'id_user' => $this->resource['user_id'],
            'user_id' => $this->getName($this->resource['user_id']),
            'name_court_owner' => $this->getName($this->resource['court_owner_id']),
            'court_owner_id' => $this->resource['court_owner_id'],
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

    protected function getName($id)
    {
        $account = User::find($id);
        return optional($account)->first_name . ' ' . optional($account)->last_name;
    }

    protected function getNameBadmintonCourt($id)
    {
        $badmintonCourt = BadmintonCourt::find($id);
        return $badmintonCourt->name;
    }
}
