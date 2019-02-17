<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'complaint' => $this->complaint,
            'description' => $this->description,
            'full_name' => $this->full_name,
            'address' => $this->address,
            'category' => $this->category,
            'image' => $this->image,
            'photos' => $this->photos,
            'status' => $this->status,
            'complaint_by' => $this->user,
            'created_at' => (string) $this->created_at->diffForHumans(),
            'updated_at' => (string) $this->updated_at->diffForHumans()
        ];
    }
}
