<?php 
	Route::group(['prefix' => 'admin','namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
	    Route::get('chuongtruyen/{id_truyen}', 'ChuongtruyenController@index')->name('chuongtruyen.index');
	    Route::get('chuongtruyen/{id_truyen}/create', 'ChuongtruyenController@create')->name('chuongtruyen.create');
	    Route::post('chuongtruyen/{id_truyen}/store', 'ChuongtruyenController@store')->name('chuongtruyen.store');
	    Route::get('chuongtruyen/{id_truyen}/edit/{id}', 'ChuongtruyenController@edit')->name('chuongtruyen.edit');
	    Route::post('chuongtruyen/{id_truyen}/update/{id}', 'ChuongtruyenController@update')->name('chuongtruyen.update');
	    Route::delete('chuongtruyen/destroy/{id}', 'ChuongtruyenController@destroy')->name('chuongtruyen.destroy');
	});
 ?>