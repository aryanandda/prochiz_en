<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
|
*/

Route::group(['middleware' => 'auth:admin'], function(){
	Route::get('/', 'DashboardController@index')->name('admin.home');
	Route::get('/export/partner', 'PartnerController@excel')->name('export.excel');

	Route::group(['prefix' => 'api'], function(){
		
		Route::get('user', 'UserController@api')->name('admin.api');
		Route::get('admin', 'AdminController@api')->name('admin.api');
		Route::get('banner', 'BannerController@api')->name('banner.api');
		Route::get('tips', 'TipsTrickController@api')->name('tips.api');
		Route::get('page', 'PageController@api')->name('page.api');
		Route::get('news', 'NewsController@api')->name('news.api');
		Route::get('event', 'EventController@api')->name('event.api');
		Route::get('partner', 'PartnerController@api')->name('partner.api');
		Route::get('partnergallery', 'PartnerGalleryController@api')->name('partner.gallery.api');
		Route::get('partnercat', 'PartnerCategoryController@api')->name('partner.category.api');
		Route::get('product', 'ProductController@api')->name('product.api');
		Route::get('video', 'VideoController@api')->name('video.api');
		Route::get('footertext', 'FooterTextController@api')->name('footertext.api');
		Route::get('recipe', 'RecipeController@api')->name('recipe.api');
		Route::get('byuser/recipe', 'RecipeUserController@api')->name('recipe.user.api');

		Route::post('footertext/empty', 'FooterTextController@emptyTrash')->name('footertext.api.empty');
		Route::post('video/empty', 'VideoController@emptyTrash')->name('video.api.empty');
		Route::post('tips/empty', 'TipsTrickController@emptyTrash')->name('tips.api.empty');
		Route::post('page/empty', 'PageController@emptyTrash')->name('page.api.empty');
		Route::post('news/empty', 'NewsController@emptyTrash')->name('news.api.empty');
		Route::post('recipe/empty', 'RecipeController@emptyTrash')->name('recipe.api.empty');
		Route::post('byuser/recipe/empty', 'RecipeUserController@emptyTrash')->name('recipe.user.api.empty');
		Route::post('byuser/recipe/setsts', 'RecipeUserController@setSts')->name('recipe.user.api.sts');
		Route::post('byuser/partner/setsts', 'PartnerController@setSts')->name('partner.user.api.sts');
		Route::post('footertext/restore/{article}', 'FooterTextController@restoreTrash')->name('footertext.api.restore');
		Route::post('page/restore/{article}', 'PageController@restoreTrash')->name('page.api.restore');
		Route::post('video/restore/{article}', 'VideoController@restoreTrash')->name('video.api.restore');
		Route::post('tips/restore/{article}', 'TipsTrickController@restoreTrash')->name('tips.api.restore');
		Route::post('news/restore/{article}', 'NewsController@restoreTrash')->name('news.api.restore');
		Route::post('recipe/restore/{article}', 'RecipeController@restoreTrash')->name('recipe.api.restore');
		Route::post('byuser/recipe/restore/{article}', 'RecipeUserController@restoreTrash')->name('recipe.user.api.restore');
	});

	Route::resource('user', 'UserController');
	Route::resource('admin', 'AdminController');
	Route::resource('banner', 'BannerController');
	Route::resource('page', 'PageController');
	Route::resource('news', 'NewsController');
	Route::resource('partner', 'PartnerController');
	Route::resource('partnergallery', 'PartnerGalleryController');
	Route::resource('partnercat', 'PartnerCategoryController');
	Route::resource('tips', 'TipsTrickController');
	Route::resource('video', 'VideoController');
	Route::resource('footertext', 'FooterTextController');
	Route::resource('event', 'EventController');
	Route::resource('product', 'ProductController');
	Route::resource('recipe', 'RecipeController');
	Route::resource('byuser/recipe', 'RecipeUserController');
});

/* Auth */
Route::middleware('guest:admin')->get('/login', 'AuthController@login')->name('admin.login');
Route::middleware('guest:admin')->post('/login', 'AuthController@doLogin')->name('admin.dologin');

Route::middleware('auth:admin')->get('/logout', 'AuthController@logout')->name('admin.logout');
