<?php 
	Route::group(['prefix' => 'admin','namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
	    Route::get('truyen', 'TruyenController@index')->name('truyen.index');
	    Route::get('truyen/create', 'TruyenController@create')->name('truyen.create');
	    Route::post('truyen/store', 'TruyenController@store')->name('truyen.store');
	    Route::get('truyen/edit/{id}', 'TruyenController@edit')->name('truyen.edit');
	    Route::post('truyen/update/{id}', 'TruyenController@update')->name('truyen.update');
	    Route::delete('truyen/destroy/{id}', 'TruyenController@destroy')->name('truyen.destroy');
	});
 ?>