<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintCategory extends Model
{
    protected $fillable = [
        'complaint_category'
    ];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
