<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dream extends Model
{
    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getImageUrlAttribute()
    {
        return asset(str_replace('\\', '/', $this->image));
    }
}
