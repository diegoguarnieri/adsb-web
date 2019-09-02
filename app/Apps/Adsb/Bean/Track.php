<?php

namespace App\Apps\Adsb\Bean;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

class Track {

    private $trackId;
    private $icao;
    private $callsign;
    private $latitude;
    private $longitude;
    private $track;
    private $altitude;
    private $groundSpeed;
    private $verticalSpeed;
    private $squawk;

    public function __construct() {

    }

    public function add() {
        $sql = array(
            'icao' => $this->icao,
            'callsign' => $this->callsign,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'track' => $this->track,
            'altitude' => $this->altitude,
            'ground_speed' => $this->groundSpeed,
            'vertical_speed' => $this->verticalSpeed,
            'squawk' => $this->squawk,
            'created' => Carbon::now()
        );
        $this->trackId = DB::table('track')->insertGetId($sql, 'track_id');
    }

    public function setIcao($icao) {
        $this->icao = $icao;
    }

    public function setCallsign($callsign) {
        $this->callsign = $callsign;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setTrack($track) {
        $this->track = $track;
    }

    public function setAltitude($altitude) {
        $this->altitude = $altitude;
    }

    public function setGroundSpeed($groundSpeed) {
        $this->groundSpeed = $groundSpeed;
    }

    public function setVerticalSpeed($verticalSpeed) {
        $this->verticalSpeed = $verticalSpeed;
    }

    public function setSquawk($squawk) {
        $this->squawk = $squawk;
    }
}
