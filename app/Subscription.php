<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    const BRONZE = 1;
    const SILVER = 2;
    const GOLD = 3;
    const PLATINUM = 4;
}
