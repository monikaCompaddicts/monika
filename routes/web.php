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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

//API Urls
Route::get('/addCategory', 'CategoryController@addCategory');
Route::get('/test-api', 'CategoryController@testApi');
Route::any('/get-category', 'CategoryController@getCategory');
Route::get('/registerCustomer', 'CustomerController@register');
Route::get('/updateCustomer', 'CustomerController@update');
Route::get('/insertAd', 'AdsController@insertAd');

//Admin Urls
Route::get('/admin/category', 'AdminController@getCategories');
Route::post('/admin/getChildCategory', 'AdminController@getChildCategory');
Route::post('/admin/saveNewCategory', 'AdminController@saveNewCategory');
Route::post('/admin/editCategory', 'AdminController@editCategory');
Route::post('/admin/deleteCategory', 'AdminController@deleteCategory');
Route::get('/admin/category/create', 'AdminController@createCategory');
Route::post('/admin/changeVendorStatus', 'AdminController@changeVendorStatus');
Route::get('/admin/send-mail/{id}', 'AdminController@sendMailToVendor');
Route::resource('tests', 'testController');



Route::resource('vendors', 'vendorController');
Route::resource('locations', 'locationController');

// Routes for API
Route::get('get-category', 'ApiController@getCategory')->middleware('cors');
Route::get('get-locations', 'ApiController@getLocations')->middleware('cors');

