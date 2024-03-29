<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->categories,
            'content' => $this->content,
            'image' => $this->image,
            'posted_by' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'link' => $this->user->avatar->avatar_link
            ],
            'created_at' => (string) $this->created_at->diffForHumans(),
            'updated_at' => (string) $this->updated_at->diffForHumans(),
            
        ];
        // return parent::toArray($request);
    }
}
