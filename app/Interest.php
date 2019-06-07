<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    const UNREAD = 0;
    const ACCEPT = 1;
    const REJECT = 2;
}
