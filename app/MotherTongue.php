<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotherTongue extends Model
{
    public function profiles()
    {
        return $this->hasMany('App\Profile');
    }
}
