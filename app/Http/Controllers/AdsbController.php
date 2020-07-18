<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use DateTime;
use App\Apps\Adsb\BO\AdsbBO;

class AdsbController extends Controller {

    public function __construct() {
        
    }

    public function search(Request $request) {
        Log::info('AdsbController->search');

        $icao = isset($request->icao) ? strtoupper($request->icao) : null;
        $callsign = isset($request->callsign) ? strtoupper($request->callsign) : null;
        $startDate = isset($request->startDate) ? new DateTime($request->startDate) : null;
        $endDate = isset($request->endDate) ? new DateTime($request->endDate) : null;

        $adsbBO = new AdsbBO();
        $tracks = $adsbBO->search($icao, $callsign, $startDate, $endDate);

        $response = ['tracks' => $tracks];
        return response()->json($response, 200);
    }

    public function coordinate(Request $request) {
        Log::info('AdsbController->coordinate');

        $adsbBO = new AdsbBO();
        $coordinates = $adsbBO->coordinate($request->id);

        $response = ['coordinates' => $coordinates];
        return response()->json($response, 200);
    }

    public function path(Request $request) {
        Log::info('AdsbController->path');

        $adsbBO = new AdsbBO();
        $paths = $adsbBO->path($request->id);

        $response = ['paths' => $path];
        return response()->json($response, 200);
    }

    public function active(Request $request) {
        Log::info('AdsbController->active');

        $adsbBO = new AdsbBO();
        $tracks = $adsbBO->active();

        $response = ['tracks' => $tracks];
        return response()->json($response, 200);
    }

    public function store(Request $request) {
        Log::info('AdsbController->store',[json_encode($request->all())]);

        $adsbBO = new AdsbBO();
        $adsbBO->store($request);

        $response = [];
        return response()->json($response, 200);
    }
}