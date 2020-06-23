<?php

$host = "localhost";
$port = "30003";
$timeout = 15;
$time = time();
$total_packets = 0;
$heartbeat = 300;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Unable to create socket\n");

if(isset($sock)) {
    echo "Connecting to dump1090...\n";
    while (!@socket_connect($sock, $host, $port)) {
        $err = socket_last_error($sock);

        if($err == 115 || $err == 114) {
            if((time() - $time) >= $timeout) {
                socket_close($sock);
                die("Connection timed out.\n");
            }
        }
        die(socket_strerror($err) . "\n");
    }

    echo "Connected!\n";

    sleep(1);

    echo "\nSCAN MODE\n\n";
    while($buffer = socket_read($sock, 3000, PHP_NORMAL_READ)) {
        //ctrl-c to kill properly
        pcntl_signal_dispatch();

        //SBS format is CSV format
        $line = explode(',', $buffer);
        if(is_array($line) && isset($line[4])) {
            $total_packets++;

            //output periodic 1 line health check
            if(($time - time()) % $heartbeat == 0) {
                if($printed_heartbeat === false) {
                    $printed_heartbeat = true;
                    echo "HEARTBEAT - " . date("H:i:s d-m-Y") . " - PID: " . getmypid() . " - Packets: {$total_packets} - SYSTEM OK\n";
                }
            } else {
                $printed_heartbeat = false;
            }

            echo json_encode($line);

            //the most important fields
            $icao = $line[4];
            $callsign = $line[10];
            $latitude = $line[14];
            $longitude = $line[15];
            $track = $line[13];
            $altitude = $line[11];
            $groundSpeed = $line[12];
            $verticalSpeed = $line[16];
            $squawk = $line[17];

            if(
                $callsign != "" ||
                $latitude != "" ||
                $longitude != "" ||
                $track != "" ||
                $altitude != "" ||
                $groundSpeed != "" ||
                $verticalSpeed != "" ||
                $squawk != ""
            ) {
                $fields = array(
                    'icao' => $icao,
                    'callsign' => $callsign,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'track' => $track,
                    'altitude' => $altitude,
                    'groundSpeed' => $groundSpeed,
                    'verticalSpeed' => $verticalSpeed,
                    'squawk' => $squawk
                );

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'http://172.16.3.50/api/adsb');
                //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);

                //request type | true = assync
                if(true) {
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                }

                curl_exec($ch);
                curl_close($ch);
            }
        }
    }
}
