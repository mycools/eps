<?php
  Route::prefix('eps')->name('eps.')->namespace('Mycools\Eps\Http\Controllers')->group(function(){
    Route::post('/endpoint', 'EpsController@postEndpoint')->name('endpoint');
    // Route::get('/success', 'EpsController@getSuccess')->name('success');
    // Route::get('/reject', 'EpsController@getReject')->name('reject');
    // Route::get('/waiting', 'EpsController@getWaiting')->name('waiting');
  });

