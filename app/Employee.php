<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    protected $hidden = ['password'];

    public function dreams()
    {
        return $this->hasMany(Dream::class);
    }
}
