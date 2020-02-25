<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProfileRequest;
use App\Profile;
use Illuminate\Support\Facades\DB;


class ProfileRequestController extends Controller
{
    public function requestReceived (Request $request) {
        $currentUserProfileId = Profile::getCurrentUserProfileId(); 
        $columns = ['created_at', 'updated_at'];
        $length = $request->length;
        $column = $request->column; 
        $dir = $request->dir;
      
        $Requests = ProfileRequest::where(array(
            'to' => $currentUserProfileId
        ))->orderBy($columns[$column], $dir)->with('profileFrom.country','profileFrom.state', 'profileFrom.city');

        $data = $Requests->paginate($length);
        return ['data' => $data, 'draw' => $request->input('draw')  ];
    }    
    
    public function requestSent (Request $request) {
        $currentUserProfileId = Profile::getCurrentUserProfileId(); 
        $columns = ['created_at', 'updated_at'];
        $length = $request->length;
        $column = $request->column; 
        $dir = $request->dir;
      
        $Requests = ProfileRequest::where(array(
            'from' => $currentUserProfileId
        ))->orderBy($columns[$column], $dir)->with('profileTo.country','profileTo.state', 'profileTo.city');

        $data = $Requests->paginate($length);
        return ['data' => $data, 'draw' => $request->input('draw')  ];
    }


    public function send(Request $request) {        
        // TODO: Need to optimise only to get the require field and not other fields
        $userProfileId = Profile::getProfileIdForSecretId($request->id);
        $currentUserProfileId = Profile::getCurrentUserProfileId();       
        
        if($request->check) {
            $requestExist = ProfileRequest::where(array(
                'from' => $currentUserProfileId,
                'to' => $userProfileId,
                'type' => $request->type
            ))->first();
            
            if($requestExist) {
                return response([
                    'status' => __('messages.info'),
                    'exists' =>  true,
                    'message' =>  __('messages.send-request-exists')
                ], 200);
            }
        }
        
        try{       
            DB::beginTransaction();           
            $profileRequest = new ProfileRequest();
            $profileRequest->from = $currentUserProfileId;
            $profileRequest->to = $userProfileId;
            $profileRequest->type = $request->type;
            $profileRequest->status = ProfileRequest::ACTIVE;
            $profileRequest->save();
            DB::commit();
            return response([
                'status' => __('messages.success'),
                'message' =>  __('messages.send-request-success')
            ], 201);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => __('messages.error'),
                'message' =>  __('messages.send-request-error'), //$e->getMessage() //
            ], 422);
        }
        
    }
}
