<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Track extends Eloquent {
    
    protected $connection = 'mongodb';
    protected $collection = 'track';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

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
