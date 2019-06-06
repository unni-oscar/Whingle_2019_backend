<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['name', 'created_by', 'gender', 'has_children', 'dob'];
    protected $guarded = ['id', 'user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'address', 'contact_number', 'id', 'user_id', 'created_at', 'updated_at'
    ];

    function user() {
        return $this->belongsTo('App\User');
    }
    public function country()
    {
        return $this->belongsTo('App\Country')->withDefault([
            'name' => 'N/A'
        ]);;
    }
    public function state()
    {
        return $this->belongsTo('App\State')->withDefault([
            'name' => 'N/A'
        ]);;
    }
    public function city()
    {
        return $this->belongsTo('App\City')->withDefault([
            'name' => 'N/A'
        ]);;
    }
    public function mother_tongue()
    {
        return $this->belongsTo('App\MotherTongue')->withDefault([
            'name' => 'N/A'
        ]);;
    }
    public function religion()
    {
        return $this->belongsTo('App\Religion')->withDefault([
            'name' => 'N/A'
        ]);
    }
    public function caste()
    {
        return $this->belongsTo('App\Caste')->withDefault([
            'name' => 'N/A'
        ]);;
    }
    public function education()
    {
        return $this->belongsTo('App\Education')->withDefault([
            'name' => 'N/A'
        ]);;
    }
    public function work()
    {
        return $this->belongsTo('App\Work')->withDefault([
            'name' => 'N/A'
        ]);;
    }
    // Getting the Current User Profile Id
    // TODO Need to optimize
    public static function getCurrentUserProfileId() 
    {
        $currentuserProfile = Profile::where('user_id', Auth::user()->id)->first();
        
        return $currentuserProfile->id;
    }

    // Getting the profile Id for secret_id

    public static function getProfileIdForSecretId($secretId)
    {
        $currentuserProfile = Profile::where('secret_id', $secretId)->first();
        
        return $currentuserProfile->id;
    }
}
