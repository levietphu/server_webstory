<?php 
	Route::get('the-loai/{slug}', 'Frontend\DanhmucController@theloai')->middleware('addvisitor')->name('theloai');
	Route::get('danh-sach/{slug}', 'Frontend\DanhmucController@danhsach')->middleware('addvisitor')->name('danhsach');
 ?>