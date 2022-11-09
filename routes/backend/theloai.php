<?php 
	Route::group(['prefix' => 'admin','namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
	    Route::get('theloai', 'TheloaiController@index')->name('theloai.index');
	    Route::get('theloai/create', 'TheloaiController@create')->name('theloai.create');
	    Route::post('theloai/store', 'TheloaiController@store')->name('theloai.store');
	    Route::get('theloai/edit/{id}', 'TheloaiController@edit')->name('theloai.edit');
	    Route::post('theloai/update/{id}', 'TheloaiController@update')->name('theloai.update');
	    Route::delete('theloai/destroy/{id}', 'TheloaiController@destroy')->name('theloai.destroy');
	});
 ?>