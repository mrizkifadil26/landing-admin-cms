<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'complaint', 'description', 'category_id', 'image_id', 'status', 'complaint_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ComplaintCategory::class);
    }
}
