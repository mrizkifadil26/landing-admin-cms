<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'location', 'description', 'category', 'image', 'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }
}
