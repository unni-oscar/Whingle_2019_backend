<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interest;
use App\Profile;
use Illuminate\Support\Facades\DB;


class InterestController extends Controller
{
    public function interestReceived (Request $request) {
        $currentUserProfileId = Profile::getCurrentUserProfileId(); 
        $columns = ['created_at', 'updated_at'];
        $length = $request->length;
        $column = $request->column; 
        $dir = $request->dir;
      
        $Interests = Interest::where(array(
            'interest_to' => $currentUserProfileId
        ))->orderBy($columns[$column], $dir)->with('profileFrom.country','profileFrom.state', 'profileFrom.city');

        $data = $Interests->paginate($length);
        return ['data' => $data, 'draw' => $request->input('draw')  ];
    }

    public function replyInterest(Request $request) {
        $currentUserProfileId = Profile::getCurrentUserProfileId(); 
        $status = ($request->action) ? Interest::ACCEPT : Interest::REJECT;
        //Checking if he/she is the owner of the interest as he/she is able to modify only interest received
        $ownInterest = Interest::where(array(
            'interest_to' => $currentUserProfileId,
            'id' => $request->id
        ))->first();
        if($ownInterest) {
            Interest::where('id', $request->id)->update(
                ['status' => $status]
            );
        } else {

        }
    }
    
    public function interestSent (Request $request) {
        $currentUserProfileId = Profile::getCurrentUserProfileId(); 
        $columns = ['created_at', 'updated_at'];
        $length = $request->length;
        $column = $request->column; 
        $dir = $request->dir;
      
        $Interests = Interest::where(array(
            'interest_from' => $currentUserProfileId
        ))->orderBy($columns[$column], $dir)->with('profileTo.country','profileTo.state', 'profileTo.city');

        $data = $Interests->paginate($length);
        return ['data' => $data, 'draw' => $request->input('draw')  ];
    }


    public function send(Request $request) {        
        // TODO: Need to optimise only to get the require field and not other fields
        $userProfileId = Profile::getProfileIdForSecretId($request->id);
        $currentUserProfileId = Profile::getCurrentUserProfileId();       
        
        if($request->check) {
            $InterestExist = Interest::where(array(
                'interest_from' => $currentUserProfileId,
                'interest_to' => $userProfileId
            ))->first();
            
            if($InterestExist) {
                return response([
                    'status' => __('messages.success'),
                    'exists' =>  true
                ], 200);
            }
        }
        
        try{       
            DB::beginTransaction();
            $interest = new Interest();
            $interest->interest_from = $currentUserProfileId;
            $interest->interest_to = $userProfileId;
            $interest->status = Interest::UNREAD;
            $interest->save();
            DB::commit();
            
            // TODO : Send email notificatoin
            // $messageNotificationJob = (new UserVerificationJob($data))->delay(Carbon::now()->addSeconds(3));
            // dispatch($messageNotificationJob);
             
            return response([
                'status' => __('messages.success'),
                'message' =>  __('messages.send-interest-success')
            ], 201);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => __('messages.error'),
                'message' =>  __('messages.send-interest-error'), //$e->getMessage() //
            ], 422);
        }
        
    }
}
