<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Track extends Eloquent {
    
    protected $connection = 'mongodb';
    protected $collection = 'track';

    protected $fillable = [
        'icao',
        'callsign',
        'latitude',
        'longitude',
        'track',
        'altitude',
        'groundSpeed',
        'verticalSpeed',
        'squawk'
    ];

}
