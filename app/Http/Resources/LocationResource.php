<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'location' => $this->location,
            'description' => $this->description,
            'category' => $this->category,
            'image' => $this->image,
            'avg_rating' => $this->ratings->avg('rating'),
            'ratings' => $this->ratings,
            'posted_by' => $this->user,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,            
        ];
    }
}
