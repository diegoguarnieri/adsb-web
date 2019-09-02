<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('adsb', 'AdsbController@store');
