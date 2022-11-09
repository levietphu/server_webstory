<?php 
	Route::get('admin/login', 'Backend\DashboardController@loginAdmin')->name('loginAdmin');
	Route::post('admin/post_login', 'Backend\DashboardController@post_loginAdmin')->name('post_loginAdmin');
	Route::get('admin/logout', 'Backend\DashboardController@logoutAdmin')->name('logoutAdmin');
 ?>