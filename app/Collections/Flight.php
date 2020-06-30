<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Flight extends Eloquent {
    
    protected $connection = 'mongodb';
    protected $collection = 'flight';

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
