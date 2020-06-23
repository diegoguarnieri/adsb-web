<?php

namespace App\Apps\Adsb\Bean;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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

    public function __construct($id) {
        if(!is_null($id)) {
            $this->getById($id);
        }
    }

    public function getById($id) {

    }

    public function save() {
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
            'created' => (new DateTime())->format('Y-m-d H:i:s.u')
        );
        $this->trackId = DB::table('track')->insertGetId($sql, 'track_id');
    }

    public function delete() {

    }

    public function getTrackId() {
		return $this->trackId;
	}

	public function setTrackId($trackId) {
		$this->trackId = $trackId;
	}

	public function getIcao() {
		return $this->icao;
	}

	public function setIcao($icao) {
		$this->icao = $icao;
	}

	public function getCallsign() {
		return $this->callsign;
	}

	public function setCallsign($callsign) {
		$this->callsign = $callsign;
	}

	public function getLatitude() {
		return $this->latitude;
	}

	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	public function getLongitude() {
		return $this->longitude;
	}

	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	public function getTrack() {
		return $this->track;
	}

	public function setTrack($track) {
		$this->track = $track;
	}

	public function getAltitude() {
		return $this->altitude;
	}

	public function setAltitude($altitude) {
		$this->altitude = $altitude;
	}

	public function getGroundSpeed() {
		return $this->groundSpeed;
	}

	public function setGroundSpeed($groundSpeed) {
		$this->groundSpeed = $groundSpeed;
	}

	public function getVerticalSpeed() {
		return $this->verticalSpeed;
	}

	public function setVerticalSpeed($verticalSpeed) {
		$this->verticalSpeed = $verticalSpeed;
	}

	public function getSquawk() {
		return $this->squawk;
	}

	public function setSquawk($squawk) {
		$this->squawk = $squawk;
	}
}
