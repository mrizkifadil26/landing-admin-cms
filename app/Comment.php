<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['user_id', 'post_id', 'comment'];

    public function users()
    {
        $this->belongsTo(User::class);
    }

    public function posts()
    {
        $this->belongsTo(Post::class);
    }
}
