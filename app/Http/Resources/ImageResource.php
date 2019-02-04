<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'image_name' => $this->image_name,
            'image_link' => $this->image_link,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'posts' => $this->posts
        ];
    }
}
