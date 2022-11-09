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
// Route::get('get_story','Api\StoryApi@getStory');
Route::get('view_chapter','Api\StoryApi@viewChapter');
Route::get('buy_chapter','Api\StoryApi@buyChapter');
Route::get('personal','Api\PersonalApi@index');