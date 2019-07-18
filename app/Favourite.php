<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    public function profileTo()
    {
        return $this->belongsTo('App\Profile', 'favourite_to', 'id');
    }
}
