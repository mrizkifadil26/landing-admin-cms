<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = [
        'avatar_name',
        'avatar_link'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'avatar', 'id');
    }
}
