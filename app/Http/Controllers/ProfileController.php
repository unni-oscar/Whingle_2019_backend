<?php

namespace App\Http\Controllers;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Country;
use App\MotherTongue;
use App\Education;
use App\Work;
use App\Religion;
use App\Http\Requests\ProfileRequest;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id); 
        $profile = $user->profile;
        $keyArr = array('created_by', 'gender', 'marital', 'yesNo', 'diet', 'drink', 'smoke', 'father','mother',
        'horoscope', 'manglik', 'star', 'moon_sign', 'family_type', 'family_values', 'family_status',
        'bro_sis', 'job_category', 'education_category', 'income', 'height', 'weight', 'build', 'complexion', 'blood_group');
        $whData = wh_arrayToObject($keyArr);
        $countries = Country::select('id', 'name')->orderBy('name', 'asc')->get(); 
        // $educations = Education::select('id', 'name')->orderBy('name', 'asc')->get();
        $jobs = Work::select('id', 'name')->orderBy('name', 'asc')->get();
        $religions = Religion::select('id', 'name')->orderBy('name', 'asc')->get(); 
        $motherTongues = MotherTongue::select('id', 'name')->orderBy('name', 'asc')->get();  
        return response()->json(compact('profile', 'countries',  'whData', 'motherTongues', 'religions', 'jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Profile::with(array('country', 'state', 'city', 'religion', 'mother_tongue', 'caste','user' => function($query){
            $query->select('id', 'last_login_at as online');
        }))->whereSecretId($request->secret_id)->firstOrFail();
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request )
    {
        $data = $request->all(); 
        $data['dob'] = Carbon::parse($request->dob)->toDateTimeString();
        $user = User::find(Auth::user()->id);
        try {
            $user->profile->update($data);
            return response()->json([
                'status' => __('messages.res.success'),
                'message' => __('messages.profile_update_success')
            ], 200);
        }  catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() //'Profile updated Error'
            ], 400);
        }     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
