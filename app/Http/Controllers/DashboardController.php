<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
//use DateTime;
use App\Apps\Adsb\BO\DashboardBO;

class DashboardController extends Controller {

    public function __construct() {
        
    }

    public function index(Request $request) {
        Log::info('DashboardController->index');

        $dashboardBO = new DashboardBO();
        $fartherTracks = $dashboardBO->getFartherTracks(-23.343638, -51.171014);
        //$dailyHits = $dashboardBO->getDailyHits(2);

        $response = [
            'fartherTracks' => $fartherTracks,
            //'dailyHits' => $dailyHits
        ];
        return response()->json($response, 200);
    }
}
