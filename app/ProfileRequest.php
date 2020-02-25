<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileRequest extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 0;
    public function profileTo()
    {
        return $this->belongsTo('App\Profile', 'to', 'id');
    }
    public function profileFrom()
    {
        return $this->belongsTo('App\Profile', 'from', 'id');
    }
}
