<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;
use App\Profile;
use Illuminate\Support\Facades\DB;


class FavouriteController extends Controller
{
    public function getFavourites(Request $request) {
        $currentUserProfileId = Profile::getCurrentUserProfileId(); 
        $columns = ['created_at', 'updated_at'];
        $length = $request->length;
        $column = $request->column; 
        $dir = $request->dir;
      
        $Interests = Favourite::where(array(
            'favourite_from' => $currentUserProfileId
        ))->orderBy($columns[$column], $dir)->with('profileTo.country','profileTo.state', 'profileTo.city');

        $data = $Interests->paginate($length);
        return ['data' => $data, 'draw' => $request->input('draw')  ];
    }

    /**
     * Removing a profile from favourites
     * params: $request
     * response: json
     */
    public function remove(Request $request) {
        $currentUserProfileId = Profile::getCurrentUserProfileId();       
        // Checking if the user has permission to delete
        $isUserAuthorised = Favourite::where(array(
            'favourite_from' => $currentUserProfileId,
            'id' => $request->id
        ))->first();
        // When a user has permission to delete the profile from favourites
        if($isUserAuthorised) {
            if(Favourite::find($request->id)->delete()) {
                return response([
                    'status' => __('messages.success'),
                    'message' =>  __('messages.remove-favourite-success')
                ], 200);
            } else {
                return response([
                    'status' => __('messages.error'),                    
                    'message' =>  __('messages.remove-favourite-error')
                ], 422);
            }
        } else {
            return response([
                'status' => __('messages.error'),                    
                'message' =>  __('messages.operation_invalid')
            ], 422);
        }
    }
    /**
     * Adding a profile to favourites
     * params: $request
     * response: json
     */
    public function add(Request $request) {        
        // TODO: Need to optimise only to get the require field and not other fields
        $userProfileId = Profile::getProfileIdForSecretId($request->id);
        $currentUserProfileId = Profile::getCurrentUserProfileId();       
        
        $favouriteExist = Favourite::where(array(
            'favourite_from' => $currentUserProfileId,
            'favourite_to' => $userProfileId
        ))->first();
        
        if($favouriteExist) {
            return response([
                'status' => __('messages.info'),
                'exists' =>  true,
                'message' =>  __('messages.add-favourite-exists')
            ], 200);
        }

        try{       
            DB::beginTransaction();
            $favourite = new Favourite();
            $favourite->favourite_from = $currentUserProfileId;
            $favourite->favourite_to = $userProfileId;
            $favourite->save();
            DB::commit();

            return response([
                'status' => __('messages.success'),
                'exists' =>  false,
                'message' =>  __('messages.add-favourite-success')
            ], 201);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => __('messages.error'),
                'message' =>  __('messages.add-favourite-error'), //$e->getMessage() //
            ], 422);
        }
        
    }
}
