<?php

Route::get('adsb', function () {
    return view('adsb');
});

Route::get('adsb/active', 'AdsbController@active');
