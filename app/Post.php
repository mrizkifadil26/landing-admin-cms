<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'category', 'content', 'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
