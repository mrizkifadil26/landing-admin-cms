<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user' => [
                'name' => $this->user->name,
                'link' => $this->user->avatar->avatar_link
            ],
            'post' => $this->post,
            'comment' => $this->comment,
            'created_at' => (string) $this->created_at->diffForHumans(),
            'updated_at' => (string) $this->updated_at->diffForHumans(),
        ];
    }
}
