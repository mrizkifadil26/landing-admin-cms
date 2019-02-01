<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['location', 'description', 'address', 'category', 'image_id'];

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
        return $this->belongsToMany(Category::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
