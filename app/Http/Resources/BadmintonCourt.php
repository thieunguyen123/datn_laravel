<?php

namespace App\Http\Resources;

use App\Models\AllCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BadmintonCourt extends JsonResource
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
            'name' => $this->name,
            'status_id' => $this->getValueKeyMap($this->status_id),
            'description' => $this->description,
            'court_owner_id' => $this->court_owner_id,
            'address' => $this->address,
            'price' => $this->price,
            'image' => $this->urlImage($this->image),
        ];
    }

    protected function getValueKeyMap($status)
    {
        $value = AllCode::where('key_map',$status)->first();
        return $value->value;
    }

    protected function urlImage($images)
    {
        $imgsDecode=[];
        $imgs = json_decode($images);
        foreach($imgs as $img){
            $imgsDecode[] = Storage::disk('public')->url($img);
        }
        return $imgsDecode;
    }
}
