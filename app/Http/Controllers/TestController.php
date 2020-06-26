<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Collections\Test;

class TestController extends Controller {

    public function __construct() {
        
    }

    public function insert() {
        $testTrack = new Test();
        $testTrack->name = 'John';
        $testTrack->email = 'john@test.com';
        $testTrack->save();
    }
}
