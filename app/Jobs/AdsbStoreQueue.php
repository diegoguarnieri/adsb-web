<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Apps\Adsb\BO\AdsbBO;

class AdsbStoreQueue implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tries = 1;
    private $request;

    public function __construct($request) {
        $this->request = json_encode($request->all());
    }

    public function handle() {
        Log::info('AdsbStoreQueue->handle',[$this->request]);

        try {
            $adsbBO = new AdsbBO();
            $adsbBO->store(json_decode($this->request));
        } catch(\Exception $e) {
            $logger->error('AdsbStoreQueue->handle - Job failed',[$e->getMessage()]);
            $this->delete();
        }
    }
}