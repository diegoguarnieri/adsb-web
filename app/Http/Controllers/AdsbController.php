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