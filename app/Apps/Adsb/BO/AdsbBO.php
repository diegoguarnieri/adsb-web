<?php

namespace App\Apps\Adsb\BO;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;
//use App\Apps\Adsb\Bean\Track;
use App\Collections\Track;
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
        $track->icao = $request->icao;
        $track->callsign = $request->callsign;
        $track->latitude = $request->latitude;
        $track->longitude = $request->longitude;
        $track->track = $request->track;
        $track->altitude = $request->altitude;
        $track->groundSpeed = $request->groundSpeed;
        $track->verticalSpeed = $request->verticalSpeed;
        $track->squawk = $request->squawk;
        $track->save();
    }
}