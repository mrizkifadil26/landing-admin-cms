<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationCategoryResource extends JsonResource
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
            'location_category' => $request->location_category,
            'created_at' => (string) $request->created_at,
            'updated_at' => (string) $request->updated_at
        ];
    }
}
