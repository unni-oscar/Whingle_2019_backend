<?php 

namespace App\whib\v1;

use Illuminate\Http\Request;
use App\User;

class UserSearch implements SearchableInterface
{

    const MODEL = User::class;
    private static $myModel = User::class;

    use SearchableTrait;

    public static function getModelInstance()
    {
        return new self::$myModel;
    }
}