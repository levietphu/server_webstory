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
Route::post('forgot','Api\AuthApi@forgot');
Route::get('getUser','Api\AuthApi@getUser');
Route::get('get_story','Api\StoryApi@getStory');
Route::get('get_chapter_story','Api\StoryApi@getChapterStory');
Route::get('addview','Api\StoryApi@addViewCount');
Route::get('view_chapter','Api\ChapterApi@viewChapter');
Route::post('add_bookmark','Api\ChapterApi@add_bookmark');
Route::post('buy_chapter','Api\ChapterApi@buyChapter');
Route::get('get_comment','Api\CommentApi@index');
Route::get('get_chidren_comment','Api\CommentApi@children');
Route::post('post_comment','Api\CommentApi@post_comment');
Route::get('donate','Api\DonateApi@index');
Route::post('add_donate','Api\DonateApi@add_donate');
Route::post('buy_many_chapters','Api\BuyManyChaptersApi@create');
Route::post('check_price','Api\BuyManyChaptersApi@check_price');
Route::post('remove_bookmark','Api\ChapterApi@remove_bookmark');
Route::get('load_cent_info','Api\LoadCentApi@info');
Route::post('get_trans_code','Api\AuthApi@getTransitionCode');
Route::post('create_transaction','Api\PaymentApi@create_transaction');
Route::get('show_transaction','Api\PaymentApi@show_transaction');
Route::get('notification','Api\NotificationApi@index');
Route::post('change_is_read','Api\NotificationApi@change_is_read');
Route::post('change_is_view','Api\NotificationApi@change_is_view');

//api cms
Route::group(['prefix' => 'cms',"namespace" => "Api\Cms"], function() {

	//Vào trang dashboard
	Route::get('dashboard','DashboardApi@index');
	Route::get('get_story_dashboard','DashboardApi@get_story_dashboard');

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
	Route::post('permission/create','PermissionApi@create');

	//Role
	Route::get('role/index','RoleApi@index');
	Route::post('role/create','RoleApi@create');
	Route::put('role/{role}/update','RoleApi@update');
	Route::delete('role/{role}/delete','RoleApi@delete');

	//Translator
	Route::get('trans/index','TranslatorApi@index');
	Route::post('trans/create','TranslatorApi@create');
	Route::put('trans/{trans}/update','TranslatorApi@update');
	Route::delete('trans/{trans}/delete','TranslatorApi@delete');

	//User
	Route::get('user/index','UserApi@index');
	Route::post('user/{user}/update_role','UserApi@update_role');
	Route::post('user/{user}/block','UserApi@block');
	Route::post('user/{user}/add_coin','UserApi@add_coin');

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

	//Discount
	Route::get('discount/{id_story}/index','DiscountApi@index');
	Route::post('discount/{id_story}/create','DiscountApi@create');
	Route::put('discount/{id_discount}/update','DiscountApi@update');
	Route::delete('discount/{id}/delete','DiscountApi@delete');

	//Bank info
	Route::get('bank_info/index','BankInfoApi@index');
	Route::post('bank_info/create','BankInfoApi@create');
	Route::put('bank_info/{bank_info}/update','BankInfoApi@update');
	Route::delete('bank_info/{bank_info}/delete','BankInfoApi@delete');

	//Load cent
	Route::get('load_cent/{id_bankinfo}/index','LoadCentApi@index');
	Route::post('load_cent/{id_bankinfo}/create','LoadCentApi@create');
	Route::put('load_cent/{load_cent}/update','LoadCentApi@update');
	Route::delete('load_cent/{load_cent}/delete','LoadCentApi@delete');

	//transaction
	Route::get('transaction/index','TransactionApi@index');
	Route::post('change_status_payment','TransactionApi@change_status_payment');

	//withdraw_money
	Route::get('withdraw_money/index','WithdrawMoneyApi@index');
	Route::post('withdraw_money/create','WithdrawMoneyApi@create');
	Route::post('accept_withdraw_money','WithdrawMoneyApi@accept_withdraw_money');

	//affiliated bank
	Route::get('affiliated_bank/index','AffiliatedBankApi@index');
	Route::post('affiliated_bank/create','AffiliatedBankApi@create');
});
