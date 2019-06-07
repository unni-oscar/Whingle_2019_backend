<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProfileRequest;
use App\Profile;
use Illuminate\Support\Facades\DB;


class ProfileRequestController extends Controller
{
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
