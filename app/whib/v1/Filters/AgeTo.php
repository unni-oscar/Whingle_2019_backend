<?php

namespace App\whib\v1\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class AgeTo implements FilterInterface
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->whereHas('profile', function ($q) use ($value) {            
            $q->where('dob', '>=', Carbon::now()->subYear($value)->toDateString());
        });   
    }
}