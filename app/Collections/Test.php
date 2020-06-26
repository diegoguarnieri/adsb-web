<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Test extends Eloquent {
    
    protected $connection = 'mongodb';
    protected $collection = 'test_track';

    protected $fillable = [
        'name', 'email'
    ];

}
