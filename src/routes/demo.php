<?php
  Route::prefix('eps')->group(function(){
    Route::get('/getMethods', 'Mycools\Eps\Http\Controllers\EpsDemoController@getMethods');
    Route::get('/getAbout', 'Mycools\Eps\Http\Controllers\EpsDemoController@getAbout');
    Route::get('/initPayment/{orderId?}', 'Mycools\Eps\Http\Controllers\EpsDemoController@initPayment')->name('eps.initPayment');
    Route::get('/initCardPayment/{orderId?}', 'Mycools\Eps\Http\Controllers\EpsDemoController@initCardPayment')->name('eps.initCardPayment');
    Route::get('/success/{orderId?}', 'Mycools\Eps\Http\Controllers\EpsDemoController@onsuccess')->name('eps.onSuccess');
    Route::get('/reject/{orderId?}', 'Mycools\Eps\Http\Controllers\EpsDemoController@onreject')->name('eps.onReject');
  });


