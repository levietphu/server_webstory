<?php 
	Route::post('post_search', 'Frontend\SearchController@post_search')->middleware('addvisitor')->name('post_search');
	
 ?>