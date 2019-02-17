<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationCategory extends Model
{
    protected $fillable = [
        'location_category'
    ];

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }
}
