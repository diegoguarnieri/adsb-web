<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use App\Apps\Adsb\Bean\Track;
use App\Apps\Util\HttpRequest;

class AdsbController extends Controller {

    public function __construct() {
        
    }

    public function active() {
        $items[] = [
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
        
        $sql = "select * from track
                 where created > date_sub(now(), interval 1 day)
              order by icao, track_id asc";
        $res = DB::select($sql);

        foreach($res as $key => $value) {
            if(isset($items[$value->icao])) {
                if($value->callsign != null || $value->callsign != 'RM' || $value->callsign != 'SL') {
                    $items[$value->icao]['callsign'] = $value->callsign;
                }

                if($value->latitude != null) {
                    $items[$value->icao]['latitude'] = $value->latitude;
                }

                if($value->longitude != null) {
                    $items[$value->icao]['longitude'] = $value->longitude;
                }

                if($value->track != null) {
                    $items[$value->icao]['track'] = $value->track;
                }

                if($value->altitude != null) {
                    $items[$value->icao]['altitude'] = $value->altitude;
                }

                if($value->ground_speed != null) {
                    $items[$value->icao]['groundSpeed'] = $value->ground_speed;
                }

                if($value->vertical_speed != null) {
                    $items[$value->icao]['verticalSpeed'] = $value->vertical_speed;
                }

                if($value->squawk != null) {
                    $items[$value->icao]['squawk'] = $value->squawk;
                }
            } else {
                $items[$value->icao] = [
                    'icao' => $value->icao,
                    'callsign' => $value->callsign,
                    'latitude' => $value->latitude,
                    'longitude' => $value->longitude,
                    'track' => $value->track,
                    'altitude' => $value->altitude,
                    'groundSpeed' => $value->ground_speed,
                    'verticalSpeed' => $value->vertical_speed,
                    'squawk' => $value->squawk
                ];
            }
        }

        $response = ['items' => $items];
        return response()->json($response, 200);
    }

    public function store(Request $request) {

        $fields = array(
            'icao' => $request->icao,
            'callsign' => $request->callsign,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'track' => $request->track,
            'altitude' => $request->altitude,
            'groundSpeed' => $request->groundSpeed,
            'verticalSpeed' => $request->verticalSpeed,
            'squawk' => $request->squawk
        );

        $httpRequest = new HttpRequest();
        $httpRequest->setUrl('http://172.16.3.50:9090');
        $httpRequest->setContentType('json');
        $httpRequest->setJsonBody(true);
        $httpRequest->setFields($fields);
        $httpRequest->setMethod('post');

        $httpRequest->exec();


        $track = new Track();

        $track->setIcao($request->icao);
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