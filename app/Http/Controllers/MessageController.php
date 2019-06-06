<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Profile;
use App\Message;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function send(Request $request) {        
        // TODO: Need to optimise only to get the require field and not other fields
        $userProfileId = Profile::getProfileIdForSecretId($request->id);
        $currentUserProfileId = Profile::getCurrentUserProfileId();       
        
        // Check if the profile is Blacklisted / rejected
    
        // Check if the current user has subscriptoin for sending message
        try{       
            DB::beginTransaction();
            $message = new Message;
            $message->message_from = $currentUserProfileId;
            $message->message_to = $userProfileId;
            $message->message = $request->message;
            
            $message->status = Message::UNREAD;
            $message->save();
            DB::commit();
            
            // TODO : Send email notificatoin
            // $messageNotificationJob = (new UserVerificationJob($data))->delay(Carbon::now()->addSeconds(3));
            // dispatch($messageNotificationJob);
             
            return response([
                'status' => __('messages.success'),
                'message' =>  __('messages.send-msg-success')
            ], 201);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => __('messages.error'),
                'message' =>  __('messages.send-msg-error'), //$e->getMessage() //
            ], 422);
        }
        
    }
}
