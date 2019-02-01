<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'event' => $request->event,
            'description' => $request->description,
            'date' => (string) $request->date,
            'location' => $request->location,
            'posted_by' => $request->user,
            'created_at' => (string) $request->created_at,
            'updated_at' => (string) $request->updated_at
        ];
    }
}
