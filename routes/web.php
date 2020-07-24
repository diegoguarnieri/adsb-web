<?php

Route::get('adsb', function () {
    return view('home');
});

/*Route::get('adsb', function () {
    return view('adsb');
});*/

Route::get('adsb/active', 'AdsbController@active');
Route::get('adsb/path/{id}', 'AdsbController@path');
Route::get('adsb/coordinate/{id}', 'AdsbController@coordinate');
Route::post('adsb/search', 'AdsbController@search');

Route::get('dashboard', 'DashboardController@index');

//Route::get('test', 'TestController@insert');
Route::get('test/get', 'TestController@get');
