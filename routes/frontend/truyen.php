<?php
	Route::group(['prefix' => '', 'namespace'=>'Frontend','middleware'=>'addvisitor'], function() {
		Route::get('dang-ky.html', 'LoginController@dangky')->name('dangky');
		Route::post('dang-ky', 'LoginController@post_dangky')->name('post_dangky');
		Route::get('dang-nhap.html', 'LoginController@dangnhap')->name('dangnhap');
		Route::post('dang-nhap', 'LoginController@post_dangnhap')->name('post_dangnhap');
		Route::post('post_dangnhap_view', 'LoginController@post_dangnhap_view')->name('post_dangnhap_view');
		Route::post('review', 'ReviewController@review')->name('review');
		Route::get('dang-xuat', 'LoginController@dangxuat')->name('dangxuat');
		// Route::post('review', 'ReviewController@review')->name('review');
		Route::post('comment', 'CommentController@comment')->name('comment');
	    Route::get('{slug_truyen}', 'TruyenController@view')->middleware('view_count')->name('view');
	    // Phân loại truyện
	    Route::get('phan-loai/{slug_phanloai}', 'TruyenController@phanloai')->name('phanloai');
	    Route::get('tac-gia/{slug_tacgia}', 'TruyenController@tacgia')->name('tacgia');
	});
 ?>