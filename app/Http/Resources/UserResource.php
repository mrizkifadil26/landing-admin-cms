<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'role' => $this->role,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'posts' => $this->posts,
            'complaints' => $this->complaints,
            'comments' => $this->comments
        ];
    }
}
