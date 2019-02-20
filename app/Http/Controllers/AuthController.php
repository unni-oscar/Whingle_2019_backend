<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\UserVerificationJob;
use App\Jobs\ResetPasswordJob;
use App\Jobs\ChangePasswordJob;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{    
    public function register() {
        $keyArr = array('created_by', 'gender', 'marital');
        $whData = wh_arrayToObject($keyArr);
        //$countries = Country::select('id', 'name')->orderBy('name', 'asc')->get(); 
        // $religions = Religion::select('id', 'name')->orderBy('name', 'asc')->get(); 
        // $motherTongues = MotherTongue::select('id', 'name')->orderBy('name', 'asc')->get();  
        return response()->json(compact('whData'));
       // return response()->json(compact('countries',  'whData', 'motherTongues'));
    }
    
    // https://medium.com/@hdcompany123/laravel-5-7-and-json-web-tokens-tymon-jwt-auth-d5af05c0659a
    public function store(RegisterRequest $request)
    {
        try{       
            DB::beginTransaction();
            $user = new User;
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->user_group_id = config('api.user_group.User');
            $user->activation_token = utf8_encode(Uuid::generate(4));
            $user->status = config('api.user_status.Pending');
            $user->save();

            $profile = new Profile();
            $profile->name = $request->name;
            $profile->user_id = $user->id;
            $profile->secret_id = Uuid::generate(4);
            $profile->created_by = $request->created_by;
            $profile->dob = Carbon::parse($request->dob)->toDateTimeString();
            $profile->marital_status = $request->marital_status;
            $profile->gender = $request->gender;
            $profile->save();
            DB::commit();
            $data = array(
                'url' => env('APP_URL').'/verify/'.$user->email.'/'.$user->activation_token
            );
            
            $emailJob = (new UserVerificationJob($data))->delay(Carbon::now()->addSeconds(3));
            dispatch($emailJob);
             
            return response([
                'status' => __('messages.res.success'),
                'message' =>  __('messages.registration-success'),
                'data' => $user
            ], 201);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => __('messages.res.error') ,
                'message' =>  __('messages.registration-failed'), //$e->getMessage() //
            ], 400);
        }
        
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => __('messages.res.error'),
                'message' => __('messages.login_error')
            ], 400);
        }
        // Record last login time and ip
        Auth::user()->last_login_at = Carbon::now()->toDateTimeString();
        Auth::user()->last_login_ip = $request->getClientIp();
        Auth::user()->save();
        return $this->respondWithToken($token);
    }

    /**
     * User verification
     * @params $request {email, token}
     * @return Json 
     */
    public function verify(Request $request) 
    {

        $user = User::where([
            'email' => $request->email,
            'activation_token' => $request->token
        ])->first();

        if($user) {
        
            if($user->email_verified_at == null) {
                $user->email_verified_at = Carbon::now();                
        
                if($user->save()) {
                    $res = array('status' => __('messages.res.success'),'message' => __('messages.email_verified_success'));
                } else {
                    $res = array('status' => __('messages.res.error'),'message' => __('messages.email_verified_failed'));
                }
            } else {
                $res = array('status' => __('messages.res.success'),'message' => __('messages.email_already_verified'));
            }            
        } else {
            $res = array('status' => __('messages.res.error'),'message' => __('messages.email_verified_error'));
        }
        return response([
            'status' => $res['status'],
            'message' => $res['message'],
            'user' => $request
        ], ($res['status'] == 'error') ? 400 : 200 );
    }

    /**
     * @params {String} email
     * @return Json
     */
    public function resetPassword(Request $request)
    {
        $user = User::where('email',$request->email )->first();
        if($user) {
            $newPassword = str_random(6);
            $user->password = bcrypt($newPassword);
            if($user->save()) {
                $emailJob = (new ResetPasswordJob($newPassword))->delay(Carbon::now()->addSeconds(3));
                dispatch($emailJob);
                $res = array('status' => __('messages.res.success'),'message' => __('messages.password_reset_success'));
            } else {
                $res = array('status' => __('messages.res.error'),'message' => __('messages.password_reset_failed'));
            }
        } else {
            $res = array('status' => __('messages.res.error'),'message' => __('messages.password_reset_invalid'));
        }
        return response([
            'status' => $res['status'],
            'message' => $res['message'],
            'user' => $user
        ], ($res['status'] == __('messages.res.error') ) ? 400 : 200 );
    }

    /**
     * @params {Object} old/new/confirm password
     * @return Json
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);
        if($user) {            
            $user->password = bcrypt($request->newPassword);
            if($user->save()) {
                $emailJob = (new ChangePasswordJob())->delay(Carbon::now()->addSeconds(3));
                dispatch($emailJob);
                $res = array('status' => 'success','message' => __('messages.password_change_success'));
            } else {
                $res = array('status' => 'error','message' => __('messages.password_change_failed'));
            }
        } else {
            $res = array('status' => 'error','message' => __('messages.operation_invalid'));
        }
        return response([
            'status' => $res['status'],
            'message' => $res['message'],
            'user' => $user
        ], ($res['status'] == 'error') ? 400 : 200 );
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     * @return Json 
     */
    public function logout(Request $request) {        
        auth()->logout();
        return response()->json([
            'status' => 'success',
            'message' => __('messages.auth.logout_success')
        ]);
    }
    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }
}