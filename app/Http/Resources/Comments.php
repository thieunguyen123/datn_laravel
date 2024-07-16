<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Comments extends JsonResource
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
            'id_parent' => $this->id_parent,
            'content' => $this->content,
            'user_name' => $this->getName($this->user_id),
            'user_id' => $this->user_id,
            'badminton_court_id' => $this->badminton_court_id,
            'childComments' => Comments::collection($this->whenLoaded('childComments')),
        ];
    }

    protected function getName($id)
    {
        $user = User::where('id', $id)->first();
        return $user->first_name . $user->last_name;
    }
}
