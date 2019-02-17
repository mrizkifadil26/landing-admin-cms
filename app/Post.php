<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'image_id', 'content', 'posted_by'
    ];

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
