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
}
