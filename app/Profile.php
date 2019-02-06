<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['name', 'created_by', 'gender', 'has_children', 'dob'];
    protected $guarded = ['id', 'user_id'];


    function user() {
        return $this->belongsTo('App\User');
    }
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    public function state()
    {
        return $this->belongsTo('App\State');
    }
    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function mother_tongue()
    {
        return $this->belongsTo('App\MotherTongue');
    }
    public function religion()
    {
        return $this->belongsTo('App\Religion');
    }
    public function caste()
    {
        return $this->belongsTo('App\Caste');
    }
    public function education()
    {
        return $this->belongsTo('App\Education');
    }
    public function work()
    {
        return $this->belongsTo('App\Work');
    }
}
