<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use DateTime;
use DateInterval;
use App\Collections\Test;
use App\Collections\Track;

class TestController extends Controller {

    public function __construct() {
        
    }

    public function insert() {
        $testTrack = new Test();
        $testTrack->name = 'John';
        $testTrack->email = 'john@test.com';
        $testTrack->save();
    }

    public function get() {
        //$track = Track::find('5ef9f66a4cf7ee0e5c0ce869');
        
        //$track = Track::where('icao', 'E48C04')
        //->take(10)
        //->get();

        /*$track = Track::where('icao', 'E48C04')
        ->where('updatedAt', '>=', (new DateTime())->sub(new DateInterval('PT600S')))
        //->where('updatedAt', '>=', (new DateTime())->sub(new DateInterval('P2D')))
        //->where('updatedAt', '>=', new DateTime('2020-06-29 11:15:00'))
        ->orderBy('updatedAt', 'desc')
        //->take(5)
        ->get()
        ;*/

        $track = Track::orderBy('updatedAt', 'desc')
        ->take(5)
        ->get();

        /*$track = Track::where('icao', 'E48C04')
        ->orderBy('updatedAt', 'desc')
        ->first();*/

        $response = $track;
        return response()->json($response, 200);
    }
}
