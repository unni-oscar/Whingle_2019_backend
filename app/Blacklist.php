<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    // Checking if cuurent user is being shortlist by other profile

    public static function isBlacklisted($currentUserProfileId, $profileId)
    {
        $blacklistedProfile = Blacklist::where(array(
            'from' => $profileId,
            'to' => $currentUserProfileId
        ))->first();
        
        return ($blacklistedProfile) ? true : false;
    }
}
