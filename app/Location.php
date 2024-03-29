<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['location', 'description', 'address', 'posted_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function categories()
    {
        return $this->belongsToMany(LocationCategory::class);
    }

    public function photos()
    {
        return $this->belongsToMany(Image::class);
    }

}
