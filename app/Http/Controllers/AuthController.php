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

            return response([
                'status' => 'success',
                'message' =>  __('messages.registration-success'),
                'data' => $user
            ], 201);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
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
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }
        return $this->respondWithToken($token);

        // $credentials = request(['email', 'password']);

        // if (! $token = auth()->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->respondWithToken($token);
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