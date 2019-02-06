<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caste extends Model
{
    public function religion()
    {
        return $this->belongsTo('App\Religion');
    }
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }
}
