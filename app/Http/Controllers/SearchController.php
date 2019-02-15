<?php

namespace App\Http\Controllers;

// use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\whib\v1\UserSearch;

class SearchController extends Controller
{
    public function index()
    {
        $keyArr = array('age');
        $whData = wh_arrayToObject($keyArr);
        return response()->json(compact('whData'));
    }

    public function filter(Request $request)
    {
       // print_r($request->input('ageFrom'));
    //   $ageFrom =  Carbon::now()->subYear($request->input('ageFrom'))->toDateString();
      //return $profile->where('dob', '>=', '2000-02-13')->get();
    //   return $user->whereHas('profile', function($query) use ($searchTerm) {
    //     $query->where('dob', '>=', '2000-02-13');
    //   };
    
        // if already logged in , else show all users
        // $currentUser = Auth::user()->id;
        // Exclude current user
        // $user = $user->newQuery()->with('profile')->where('id' , '!=' , $currentUser);

        // $search = $request->input('ageFrom');
        // $users = $user
        //     ->whereHas('profile', function ($query) use ($request) {
        //         $query->where('dob', '<=', Carbon::now()->subYear($request->input('ageFrom'))->toDateString());
        //     })->get();
        // return $users;

        return UserSearch::apply($request);
        
    }
}
