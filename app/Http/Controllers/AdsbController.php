<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Apps\Adsb\BO\AdsbBO;

class AdsbController extends Controller {

    public function __construct() {
        
    }

    public function active() {
        $response = [];
        return response()->json($response, 200);

        $sql = "select * from track
                 where created > date_sub(now(), interval 1 day)
              order by icao, track_id asc";
        $res = DB::select($sql);

        foreach($res as $key => $value) {
            if(isset($items[$value->icao])) {
                if($value->callsign != null && $value->callsign != 'RM' && $value->callsign != 'SL') {
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

                $items[$value->icao]['timestamp'] = $value->created;
                
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
                    'squawk' => $value->squawk,
                    'timestamp' => $value->created
                ];
            }
        }

        $response = ['items' => $items];
        return response()->json($response, 200);
    }

    public function store(Request $request) {
        Log::info('AdsbController->store',[json_encode($request->all())]);

        $adsbBO = new AdsbBO();
        $adsbBO->storeTrack($request);

        $response = [];
        return response()->json($response, 200);
    }
}