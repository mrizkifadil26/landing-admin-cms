<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'image', 'status', 'complaint_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
