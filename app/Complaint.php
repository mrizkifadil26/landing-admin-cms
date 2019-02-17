<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'complaint', 'description', 'full_name', 'address', 'category_id', 'image_id', 'status', 'complaint_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'complaint_by', 'id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }

    public function photos()
    {
        return $this->belongsToMany(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(ComplaintCategory::class, 'category_id', 'id');
    }
}
