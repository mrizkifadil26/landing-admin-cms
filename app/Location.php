<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['location', 'description', 'address', 'image_id', 'posted_by'];

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

    public function gallery()
    {
        return $this->belongsToMany(Image::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

}
