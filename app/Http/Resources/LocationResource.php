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
            'address' => $this->address,
            'category' => $this->categories,
            'avg_rating' => number_format($this->ratings->avg('rating'), 2),
            'ratings' => $this->ratings,
            'photos' => $this->photos,
            'posted_by' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'link' => $this->user->avatar->avatar_link
            ],
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,            
        ];
    }
}
