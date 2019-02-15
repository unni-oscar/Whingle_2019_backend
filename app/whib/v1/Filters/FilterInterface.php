<?php

namespace App\whib\v1\Filters;

use Illuminate\Database\Eloquent\Builder;


interface FilterInterface 
{
    public static function apply(Builder $builder, $value);
}