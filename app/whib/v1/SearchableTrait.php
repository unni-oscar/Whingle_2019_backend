<?php


namespace App\whib\v1;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


trait SearchableTrait
{
    public static function apply(Request $filters)
    {
        $model = self::MODEL;

        $query = static::applyDecoratorsFromRequest($filters, (self::getModelInstance())->newQuery());
        return static::getResults($query);
    }

    public static function getResults(Builder $query)
    {
        return $query->get();
    }

    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        $currentUser = Auth::user()->id;
        $query->with('profile.country', 'profile.state', 'profile.city')
        ->where('id', '!=', $currentUser);

        foreach ($request->all() as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }
    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' .
            str_replace(
            ' ',
            '',
            ucwords(str_replace('_', ' ', $name))
        );
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }
}
