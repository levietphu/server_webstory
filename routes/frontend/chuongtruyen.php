<?php 

	Route::get('{slug_truyen}/{slug_chapter}', 'Frontend\ChuongtruyenController@index')->middleware(['checkChapter','reading','addvisitor'])->name('chuongtruyen');
 ?>