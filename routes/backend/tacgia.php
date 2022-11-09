<?php 
	Route::group(['prefix' => 'admin','namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
	    Route::get('tacgia', 'TacgiaController@index')->name('tacgia.index');
	    Route::get('tacgia/create', 'TacgiaController@create')->name('tacgia.create');
	    Route::post('tacgia/store', 'TacgiaController@store')->name('tacgia.store');
	    Route::get('tacgia/edit/{id}', 'TacgiaController@edit')->name('tacgia.edit');
	    Route::post('tacgia/update/{id}', 'TacgiaController@update')->name('tacgia.update');
	    Route::delete('tacgia/destroy/{id}', 'TacgiaController@destroy')->name('tacgia.destroy');
	});
 ?>