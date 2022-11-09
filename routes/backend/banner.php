<?php
Route::group(['prefix' => 'admin', 'namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
    // Cấu hình

    // Logo
    Route::get('banner', 'BannerController@index')->name('banner.index');
    Route::get('banner/create', 'BannerController@create')->name('banner.create');
    Route::post('banner/store', 'BannerController@store')->name('banner.store');
    Route::get('banner/{banner}/edit', 'BannerController@edit')->name('banner.edit');
    Route::put('banner/{banner}', 'BannerController@update')->name('banner.update');
    Route::delete('banner/{banner}', 'BannerController@destroy')->name('banner.destroy');
});
