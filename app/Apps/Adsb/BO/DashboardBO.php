<?php

namespace App\Apps\Adsb\BO;

use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\DB;
use DateTime;
use DateInterval;
use App\Collections\Track;
use App\Collections\Flight;

class DashboardBO {

    public function __construct() {

    }

    public function getFartherTracks($latitude, $longitude) {
        $flights = Flight::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();

        $rate = 40030000 / 360;

        $farthers = array();
        foreach($flights as $key => $flight) {

            $howFar = sqrt(pow($latitude - $flight->latitude,2) + pow($longitude - $flight->longitude,2));

            $farthers[] = [
                'id' => $flight->id,
                'icao' => $flight->icao,
                'callsign' => $flight->callsign,
                'howFar' => round(($howFar * $rate) / 1000,2),
                'date' => (new DateTime($flight->updatedAt))->format('d/m/Y H:i:s')
            ];
        }

        $sortOption = array('desc' => SORT_DESC, 'asc' => SORT_ASC, 'string' => SORT_STRING, 'numeric' => SORT_NUMERIC);

        $columns = array();
        $columns[0] = array_column($farthers, 'howFar');
        $param[] = &$columns[0];
        $param[] = &$sortOption['desc'];
        $param[] = &$farthers;
        
        call_user_func_array('array_multisort', $param);

        $f = array();
        $i = 0;
        foreach($farthers as $key => $farther) {
            if($i == 49) {
                break;
            }
            $i++;
            
            $f[] = $farther;
        }

        return $f;
    }
}
