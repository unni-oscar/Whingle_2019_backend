<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $visible = ['id', 'name'];
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    public function cities()
    {
        return $this->hasMany('App\City');
    }
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }

}
