<?php 
	Route::group(['prefix' => 'admin','namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
	    Route::get('', 'DashboardController@index')->name('admin');
	});
 ?>