<?php

namespace App\Http\Resources;

use App\Models\AllCode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->getValueKeyMap($this->gender),
            'role_id' => $this->getValueKeyMap($this->role_id) ,
            'updated_at' => $this->updated_at->format('H:i:s d-m-Y'),
            'image' => $this->urlImage($this->image),
        ];
    }

    protected function getValueKeyMap($keyWord) {
        $allCode = AllCode::where('key_map', $keyWord)->first();
        return optional($allCode)->value;
    }

    protected function urlImage($images)
    {
        return Storage::disk('public')->url($images);
    }
}
