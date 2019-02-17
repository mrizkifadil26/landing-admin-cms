<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'image_name',
        'image_link'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'image_id', 'id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'image_id', 'id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'image_id', 'id');
    }

    public function locationPhotos()
    {
        return $this->belongsToMany(Location::class);
    }

    public function complaintPhotos()
    {
        return $this->belongsToMany(Complaint::class);
    }
}
