<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use App\Apps\Adsb\Bean\Track;

class AdsbController extends Controller {

    public function __construct() {
        
    }

    public function active() {
        $items['ZZZ'] = [
            'icao' => 'ZZZ',
            'callsign' => 'ABC1234',
            'latitude' => '45.23',
            'longitude' => '56.32',
            'track' => '109',
            'altitude' => '15000',
            'groundSpeed' => '135',
            'verticalSpeed' => '150',
            'squawk' => ''
        ];
        $items['XXX'] = [
            'icao' => 'XXX',
            'callsign' => 'ABC1234',
            'latitude' => '45.23',
            'longitude' => '56.32',
            'track' => '109',
            'altitude' => '15000',
            'groundSpeed' => '135',
            'verticalSpeed' => '150',
            'squawk' => ''
        ];
        $items['XXX'] = [
            'icao' => 'XXX',
            'callsign' => 'ABC1234',
            'latitude' => '45.23',
            'longitude' => '56.32',
            'track' => '109',
            'altitude' => '15000',
            'groundSpeed' => '135',
            'verticalSpeed' => '150',
            'squawk' => ''
        ];

        $response = ['items' => $items];
        return response()->json($response, 200);
    }

    public function store(Request $request) {

        $track = new Track();

        $track->seticao($request->icao);
        $track->setCallsign($request->callsign);
        $track->setLatitude($request->latitude);
        $track->setLongitude($request->longitude);
        $track->setTrack($request->track);
        $track->setAltitude($request->altitude);
        $track->setGroundSpeed($request->groundSpeed);
        $track->setVerticalSpeed($request->verticalSpeed);
        $track->setSquawk($request->squawk);

        $track->add();

        $response = [];
        return response()->json($response, 200);
    }
}