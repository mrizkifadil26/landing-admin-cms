<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AvatarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar_name' => $this->avatar_name,
            'avatar_link' => $this->avatar_link,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'users' => $this->users
        ];
    }
}
