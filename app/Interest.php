<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    const UNREAD = 0;
    const ACCEPT = 1;
    const REJECT = 2;
    public function profileTo()
    {
        return $this->belongsTo('App\Profile', 'interest_to', 'id');
    }
    public function profileFrom()
    {
        return $this->belongsTo('App\Profile', 'interest_from', 'id');
    }
}
