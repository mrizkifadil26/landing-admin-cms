<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $fillable = [
        'post_category'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

}
