<?php

namespace App\Apps\Adsb\BO;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Apps\Adsb\Bean\Track;
use App\Apps\Util\HttpRequest;

class AdsbBO {

    public function __construct() {

    }

    public function storeTrack($request) {

        $fields = array(
            'icao' => $request->icao,
            'callsign' => $request->callsign,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'track' => $request->track,
            'altitude' => $request->altitude,
            'groundSpeed' => $request->groundSpeed,
            'verticalSpeed' => $request->verticalSpeed,
            'squawk' => $request->squawk,
            'timestamp' => (new DateTime())->format('Y-m-d H:i:s.u')
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

        $track->save();
    }
}