<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Apps\Adsb\BO\AdsbBO;

class AdsbController extends Controller {

    public function __construct() {
        
    }

    public function path(Request $request) {
        Log::info('AdsbController->path');

        $adsbBO = new AdsbBO();
        $coordinates = $adsbBO->coordinate($request->id);

        $response = ['coordinates' => $coordinates];
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