<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $visible = ['id', 'name'];
    public function state()
    {
        return $this->belongsTo('App\State');
    }
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }
}
