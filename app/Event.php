<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event', 'description', 'start_date', 'end_date', 'location', 'posted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }


}
