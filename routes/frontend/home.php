<?php 

Route::group(['prefix' => '','namespace'=>'Frontend','middleware'=>'addvisitor'], function() {
    Route::get('', 'HomeController@index')->name('home');
    Route::get('search', 'SearchController@search')->name('search');
});