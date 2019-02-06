<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // protected $visible = ['id', 'name'];
    
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }
    public function states()
    {
        return $this->hasMany('App\State');
    }
}
