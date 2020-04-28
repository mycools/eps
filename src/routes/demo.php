<?php
  Route::prefix('eps')->name('eps.demo.')->namespace('Mycools\Eps\Http\Controllers')->group(function(){
    Route::get('/getMethods', 'EpsDemoController@getMethods');
    Route::get('/getAbout', 'EpsDemoController@getAbout');
    Route::get('/initPayment/{orderId?}', 'EpsDemoController@initPayment')->name('initPayment');
    Route::get('/initCardPayment/{orderId?}', 'EpsDemoController@initCardPayment')->name('initCardPayment');
    Route::get('/success/{orderId?}', 'EpsDemoController@onsuccess')->name('onSuccess');
    Route::get('/reject/{orderId?}', 'EpsDemoController@onreject')->name('onReject');
  });


