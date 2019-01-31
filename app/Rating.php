<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    protected $fillable = ['location_id', 'user_id', 'rating'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
