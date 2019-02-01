<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintCategoryResource extends JsonResource
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
            'complaint_category' => $request->complaint_category,
            'created_at' => (string) $request->created_at,
            'updated_at' => (string) $request->updated_at
        ];
    }
}
