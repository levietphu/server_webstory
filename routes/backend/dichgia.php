<?php 
	Route::group(['prefix' => 'admin','namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
	    Route::get('dichgia', 'DichgiaController@index')->name('dichgia.index');
	    Route::get('dichgia/create', 'DichgiaController@create')->name('dichgia.create');
	    Route::post('dichgia/store', 'DichgiaController@store')->name('dichgia.store');
	    Route::get('dichgia/edit/{id}', 'DichgiaController@edit')->name('dichgia.edit');
	    Route::post('dichgia/update/{id}', 'DichgiaController@update')->name('dichgia.update');
	    Route::delete('dichgia/destroy/{id}', 'DichgiaController@destroy')->name('dichgia.destroy');
	});
 ?>