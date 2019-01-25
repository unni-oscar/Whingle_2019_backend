<?php

// configuration file 
const wh_cFile = 'api.';

/**
 *  Return the value based on the key/id passed from global config
 */
function wh_flip($arr, $key = '')
{
    if(isset($arr) && !empty($key)) {
        $fa = array_flip(config(wh_cFile . $key));
        return $fa[$arr[$key]];
    }
    return "";
}

function wh_getAge($dob) {
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dob), date_create($today));
    return  wh_dateIND($dob). ' / ' .$diff->format('%y Yrs');
}

function wh_dateIND($date) {
    return date_format(date_create($date), "d-m-Y");
}

function wh_dateUS($date) {
    return date_format(date_create($date), "Y-m-d");
}

function wh_arrayToObject($arr) {
    $whData = array();
    
    foreach($arr as $key) {
        $data = array();
        foreach( config( wh_cFile . $key) as $k => $v) {
            array_push($data, ['id' => $v, 'name' => $k]);
        }
        $whData[$key] = $data;
    }
    return response()->json($whData)->getData();
}
function wh_arrayFlip($arr) {
    $whData = array();
    
    foreach($arr as $key) {
        $data = array();
        foreach( config( wh_cFile . $key) as $k => $v) {
            array_push($data, ['id' => $v, 'name' => $k]);
        }
       $whData[$key] = $data;
    }
    return response()->json($whData)->getData();
}
function wh_getAgeList() {
    $data = array();
    for ($i = 18; $i <= 70; $i++) {
        array_push($data, ['id' => $i, 'name' => $i]);
    }
    return $data;
}
 