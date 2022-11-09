<?php
Route::group(['prefix' => 'admin', 'namespace'=>'Backend','middleware'=>'checkAdmin'], function() {
    // Cấu hình

    // Logo
    Route::get('logo', 'LogoController@index')->name('logo.index');
    Route::get('logo/create', 'LogoController@create')->name('logo.create');
    Route::post('logo/store', 'LogoController@store')->name('logo.store');
    Route::get('logo/{logo}/edit', 'LogoController@edit')->name('logo.edit');
    Route::put('logo/{logo}', 'LogoController@update')->name('logo.update');
    Route::delete('logo/{logo}', 'LogoController@destroy')->name('logo.destroy');

    // Quảng cáo
    Route::get('ads', 'AdsController@index')->name('ads.index');
    Route::get('ads/create', 'AdsController@create')->name('ads.create');
    Route::post('ads/store', 'AdsController@store')->name('ads.store');
    Route::get('ads/{ads}/edit', 'AdsController@edit')->name('ads.edit');
    Route::put('ads/{ads}', 'AdsController@update')->name('ads.update');
    Route::delete('ads/{ads}', 'AdsController@destroy')->name('ads.destroy');
    Route::get('ads/{id}/hidden', 'AdsController@hidden')->name('ads.hidden');

    // Liên lạc
    Route::get('contact', 'ContactController@index')->name('contact.index');
    Route::get('contact/{contact}/edit', 'ContactController@edit')->name('contact.edit');
    Route::put('contact/{contact}', 'ContactController@update')->name('contact.update');

});
