<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('layout','Api\LayoutApi@index');
Route::get('home','Api\HomeApi@index');
Route::get('cate','Api\MultiApi@index');
Route::get('list','Api\MultiApi@list');
Route::get('translator','Api\MultiApi@translator');
Route::get('search','Api\SearchApi@index');
Route::get('search_chapter','Api\SearchApi@searchChapter');
Route::post('register','Api\AuthApi@register');
Route::post('login','Api\AuthApi@login');
Route::get('getUser','Api\AuthApi@getUser');
Route::get('get_story','Api\StoryApi@getStory');
Route::get('addview','Api\StoryApi@addViewCount');
Route::get('view_chapter','Api\StoryApi@viewChapter');
Route::get('buy_chapter','Api\StoryApi@buyChapter');
Route::get('get_comment','Api\CommentApi@index');

//api cms
Route::group(['prefix' => 'cms',"namespace" => "Api\Cms"], function() {
	//tác giả
	Route::get('author/index','AuthorApi@index');
	Route::post('author/create','AuthorApi@create');
	Route::put('author/{author}/update','AuthorApi@update');
	Route::delete('author/{author}/delete','AuthorApi@delete');

	//thể loại
	Route::get('cate/index','CategoryApi@index');
	Route::post('cate/create','CategoryApi@create');
	Route::put('cate/{cate}/update','CategoryApi@update');
	Route::delete('cate/{cate}/delete','CategoryApi@delete');

	//Banner
	Route::get('banner/index','BannerApi@index');
	Route::post('banner/create','BannerApi@create');
	Route::put('banner/{banner}/update','BannerApi@update');
	Route::delete('banner/{banner}/delete','BannerApi@delete');
	Route::post('upload_banner/{id}','BannerApi@uploadBanner');

	//Config
		//logo
		Route::get('logo/index','LogoApi@index');
		Route::post('logo/create','LogoApi@create');
		Route::put('logo/{logo}/update','LogoApi@update');
		Route::post('logo/{logo}/hidden','LogoApi@hidden');
		Route::post('upload_logo/{id}', "LogoApi@uploadLogo");

		//ads
		Route::get('ads/index','AdsApi@index');
		Route::post('ads/create','AdsApi@create');
		Route::put('ads/{ads}/update','AdsApi@update');
		Route::post('ads/{ads}/hidden','AdsApi@hidden');

		//contact
		Route::get('contact/index','ContactApi@index');
		Route::put('contact/{contact}/update','ContactApi@update');

	//Permission
	Route::get('permission/index','PermissionApi@index');
	Route::post('permission/create','PermissionApi@create');
	Route::get('permission/{permission}/edit','PermissionApi@edit');
	Route::put('permission/{permission}/update','PermissionApi@update');
	Route::delete('permission/{permission}/delete','PermissionApi@delete');

	//Role
	Route::get('role/index','RoleApi@index');
	Route::get('role/create','RoleApi@create');
	Route::post('role/store','RoleApi@store');
	Route::get('role/{role}/edit','RoleApi@edit');
	Route::put('role/{role}/update','RoleApi@update');
	Route::post('role/{role}/hidden','RoleApi@hidden');

	//Translator
	Route::get('trans/index','TranslatorApi@index');
	Route::post('trans/create','TranslatorApi@create');
	Route::get('trans/{trans}/edit','TranslatorApi@edit');
	Route::put('trans/{trans}/update','TranslatorApi@update');
	Route::delete('trans/{trans}/delete','TranslatorApi@delete');

	//User
	Route::get('user/index','UserApi@index');
	Route::post('user/{user}/add_role','UserApi@add_role');
	Route::put('user/{user}/update','UserApi@update');
	Route::post('user/{user}/hidden','UserApi@hidden');

	//Story
	Route::get('story/index','StoryApi@index');
	Route::get('story/create','StoryApi@create');
	Route::post('story/store','StoryApi@store');
	Route::get('story/{story}/edit','StoryApi@edit');
	Route::put('story/{story}/update','StoryApi@update');
	Route::delete('story/{story}/delete','StoryApi@destroy');
	Route::post('upload_story/{id}', "StoryApi@upload");

	//Chapter
	Route::get('chapter/{id_story}/index','ChapterApi@index');
	Route::post('chapter/{id_story}/create','ChapterApi@create');
	Route::put('chapter/{id_story}/update/{id_chapter}','ChapterApi@update');
	Route::delete('chapter/{id}/delete/','ChapterApi@destroy');
});
