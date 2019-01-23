<?php
namespace App\Http\Controllers;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\User;
class AuthController extends Controller
{
    


    // https://medium.com/@hdcompany123/laravel-5-7-and-json-web-tokens-tymon-jwt-auth-d5af05c0659a
    public function register(Request $request)
    {
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email'    => $request->email,
    //         'password' => $request->password,
    //     ]);

    //    $token = auth()->login($user);

    //    return $this->respondWithToken($token);

        //return $request;
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
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
    public function login(Request $request)
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
            'message' => __('messages.auth.logout_success') // 'Successfully logged out'
        ]);
    }
    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }
}