<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    public function castes()
    {
        return $this->hasMany('App\Caste');
    }
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }
}
