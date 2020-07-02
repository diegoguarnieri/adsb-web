<?php

namespace App\Apps\Adsb\BO;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use App\Collections\Track;
use App\Collections\Flight;
use App\Apps\Util\HttpRequest;

class AdsbBO {

    public function __construct() {

    }

    public function active() {
        $flights = Flight::where('updatedAt', '>=', (new DateTime())->sub(new DateInterval('P1D')))
        ->orderBy('updatedAt', 'desc')
        ->get();

        $tracks = array();
        foreach($flights as $flightKey => $flight) {
            $tracks[$flight->_id] = [
                'icao' => $flight->icao,
                'callsign' => $flight->callsign,
                'latitude' => $flight->latitude,
                'longitude' => $flight->longitude,
                'track' => $flight->track,
                'altitude' => $flight->altitude,
                'groundSpeed' => $flight->groundSpeed,
                'verticalSpeed' => $flight->verticalSpeed,
                'squawk' => $flight->squawk,
                'timestamp' => (new DateTime($flight->updatedAt))->format('d/m/Y H:i:s')
            ];
        }

        return $tracks;
    }

    public function store($request) {

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

        /*$flight = Flight::where('icao', $request->icao)
        ->where('updatedAt', '>=', (new DateTime())->sub(new DateInterval('PT600S')))
        ->orderBy('updatedAt', 'desc')
        ->first();*/

        //icao and (updatedAt or (updatedAt and callsign))
        $flight = Flight::where('icao', $request->icao)
        ->where(function ($query) {
            $query->where('updatedAt', '>=', (new DateTime())->sub(new DateInterval('PT10M')))
            ->orWhere(function ($query) {
                $query->where('updatedAt', '>=', (new DateTime())->sub(new DateInterval('PT20H')))
                ->where('callsign', $request->callsign);
            });
        })
        ->orderBy('updatedAt', 'desc')
        ->first();

        if($flight === null) {
            $flight = new Flight();
            $flight->icao = $request->icao;
            $flight->callsign = $request->callsign;
            $flight->latitude = $request->latitude;
            $flight->longitude = $request->longitude;
            $flight->track = $request->track;
            $flight->altitude = $request->altitude;
            $flight->groundSpeed = $request->groundSpeed;
            $flight->verticalSpeed = $request->verticalSpeed;
            $flight->squawk = $request->squawk;
            $flight->save();
        } else {
            if(!is_null($request->callsign)) $flight->callsign = $request->callsign;
            if(!is_null($request->latitude)) $flight->latitude = $request->latitude;
            if(!is_null($request->longitude)) $flight->longitude = $request->longitude;
            if(!is_null($request->track)) $flight->track = $request->track;
            if(!is_null($request->altitude)) $flight->altitude = $request->altitude;
            if(!is_null($request->groundSpeed)) $flight->groundSpeed = $request->groundSpeed;
            if(!is_null($request->verticalSpeed)) $flight->verticalSpeed = $request->verticalSpeed;
            if(!is_null($request->squawk)) $flight->squawk = $request->squawk;
            $flight->save();
        }

        $fields = array(
            'id' => $flight->_id,
            'icao' => $flight->icao,
            'callsign' => $flight->callsign,
            'latitude' => $flight->latitude,
            'longitude' => $flight->longitude,
            'track' => $flight->track,
            'altitude' => $flight->altitude,
            'groundSpeed' => $flight->groundSpeed,
            'verticalSpeed' => $flight->verticalSpeed,
            'squawk' => $flight->squawk,
            'timestamp' => (new DateTime($flight->updatedAt))->format('d/m/Y H:i:s')
        );

        $httpRequest = new HttpRequest();
        $httpRequest->setUrl('http://172.16.3.120:9090');
        $httpRequest->setContentType('json');
        $httpRequest->setJsonBody(true);
        $httpRequest->setFields($fields);
        $httpRequest->setMethod('post');
        $httpRequest->setRequestType('async');

        $httpRequest->exec();
    }
}