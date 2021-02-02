<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');
Route::get('/login/facebook', 'Auth\FacebookController@login');
Route::get('/login/facebook/callback', 'Auth\FacebookController@callback');

Route::get('/', 'HomeController@index')->name('web.home');
Route::get('/search', 'HomeController@search');

Route::get('/page/{slug}', 'PageController@show');

Route::get('/news', 'NewsController@index');
Route::get('/news/{slug}', 'NewsController@show');

Route::get('/tips', 'TipsTrickController@index');
Route::get('/tips/{slug}', 'TipsTrickController@show');

Route::get('/video', 'VideoController@index');
Route::get('/video/{slug}', 'VideoController@show');

Route::middleware('auth')->get('/upload-resep', 'RecipeController@create');
Route::middleware('auth')->post('/upload-resep', 'RecipeController@store');

Route::get('/resep/{type}', 'RecipeController@index');
Route::get('/resep/{type}/kategori/{slug}', 'RecipeController@category');
Route::get('/resep/{type}/{id}/{slug}', 'RecipeController@show');

Route::get('/event/{slug}', 'EventController@show');
Route::get('/event/{slug}/resep', 'EventController@recipes');

Route::get('/produk', 'ProductController@index');
Route::get('/produk/{slug}', 'ProductController@show');

Route::get('/kuliner', 'KulinerController@index');
Route::get('/kuliner/kategori/{slug}', 'KulinerController@category');
Route::get('/kuliner/{id}/{slug}', 'KulinerController@show');

Route::get('/partner', 'PartnerController@landing');
Route::middleware('auth')->get('/partner/register', 'PartnerController@create');
Route::middleware('auth')->post('/partner/register', 'PartnerController@store');

Route::middleware('auth')->get('/my-account/kuliner', 'PartnerController@index');
Route::middleware('auth')->get('/my-account/kuliner/{id}', 'PartnerController@edit');
Route::middleware('auth')->post('/my-account/kuliner/{id}', 'PartnerController@update');

Route::middleware('auth')->get('/my-account/kuliner/{id}/galeri', 'PartnerGalleryController@index');
Route::middleware('auth')->post('/my-account/kuliner/{id}/galeri', 'PartnerGalleryController@store');
Route::middleware('auth')->get('/my-account/kuliner/{id}/galeri/delete/{gallery_id}', 'PartnerGalleryController@destroy');

Route::middleware('auth')->get('/my-account', 'UserController@index');
Route::middleware('auth')->post('/my-account', 'UserController@update');
Route::middleware('auth')->get('/my-account/resep', 'UserController@recipe');
Route::middleware('auth')->get('/my-account/password', 'UserController@password');
Route::middleware('auth')->post('/my-account/password', 'UserController@updatePassword');

Route::get('/sitemap', 'SitemapController@index');
Route::get('/sitemap/produk', 'SitemapController@products');
Route::get('/sitemap/resep/{type}', 'SitemapController@recipes');
Route::get('/sitemap/{type}', 'SitemapController@articles');

