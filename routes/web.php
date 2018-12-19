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
	return redirect('/dashboard');//api/get-ad-bycatid
    //return view('welcome');
});


Auth::routes();

Route::get('/home', function () {
	return redirect('/dashboard');
    //return view('welcome');
});
Route::get('/send/email', 'HomeController@mail');
Route::get('/dashboard', 'HomeController@index');
Route::get('/profile', 'HomeController@profile');
Route::post('/updateUserData', 'HomeController@updateUserData');
Route::post('/changeUserPassword', 'HomeController@changeUserPassword');


//Admin Urls
Route::get('category', 'AdminController@getCategories');
Route::post('getChildCategory', 'AdminController@getChildCategory');
Route::post('saveNewCategory', 'AdminController@saveNewCategory');
Route::post('editCategory', 'AdminController@editCategory');
Route::post('deleteCategory', 'AdminController@deleteCategory');
Route::get('category/create', 'AdminController@createCategory');
Route::post('changeVendorStatus', 'AdminController@changeVendorStatus');
Route::post('changeAdStatus', 'AdminController@changeAdStatus');
Route::get('send-mail/{id}', 'AdminController@sendMailToVendor');
Route::post('orderCategory', 'AdminController@orderCategory');
Route::get('cms', 'AdminController@cms');
Route::post('getCMSContent', 'AdminController@getCMSContent');
Route::post('updateCMS', 'AdminController@updateCMS');
Route::get('advertisement', 'AdminController@advertisement');
Route::post('advertisement', 'AdminController@saveAdvertisement');
Route::post('updateAdvertisement', 'AdminController@updateAdvertisement');
Route::get('vendor-ad/{ad_id}', 'AdminController@vendorAd');
Route::get('customers', 'AdminController@customers');
Route::get('ticker', 'AdminController@ticker');
Route::post('saveTicker', 'AdminController@saveTicker');
Route::get('vendorslist/{alpha?}', 'vendorController@getVendorsByAlpha');

Route::resource('tests', 'testController');
Route::resource('vendors', 'vendorController');
Route::resource('locations', 'locationController');
Route::resource('banners', 'bannerController');

Route::post('/change-advertismente-status', 'advertisementController@changeAdvertismenteStatus');

Route::post('change-client-status', 'advertisementClientsController@toggleClientStatus');

// Routes for API
Route::get('api/get-category', 'ApiController@getCategory')->middleware('cors');
Route::get('api/get-category-app', 'ApiController@getCategoryApp')->middleware('cors');
Route::get('api/get-locations', 'ApiController@getLocations')->middleware('cors');
Route::get('api/get-banner', 'ApiController@getbanners')->middleware('cors');
Route::post('api/add-vendor', 'ApiController@addVendor')->middleware('cors');
Route::post('api/login-vendor', 'ApiController@loginVendor')->middleware('cors');
Route::post('api/forgot-password', 'ApiController@forgotPassword')->middleware('cors');
Route::get('api/get-sub-category/{id}', 'ApiController@getSubCategory')->middleware('cors');
Route::get('api/get-sub-category-app/{id}', 'ApiController@getSubCategoryApp')->middleware('cors');
Route::post('api/post-ad', 'ApiController@postAd')->middleware('cors');
Route::get('api/get-ad/{vendor_id?}', 'ApiController@getAd')->middleware('cors');
Route::get('api/get-ad-app/{vendor_id?}', 'ApiController@getAdApp')->middleware('cors');
Route::post('api/get-ad-bycatid', 'ApiController@getAdByCategory')->middleware('cors');
Route::get('api/get-ad-details/{ad_id}', 'ApiController@getAdDetail')->middleware('cors');
Route::post('api/send-enquiry', 'ApiController@sendEnquiry')->middleware('cors');
Route::post('api/receive-alert-user', 'ApiController@receiveAlertUser')->middleware('cors');
Route::post('api/search-ads', 'ApiController@searchAds')->middleware('cors');
Route::get('api/get-advertisement/{page?}', 'ApiController@getAdvertisement')->middleware('cors');
Route::get('api/get-advertisement-app', 'ApiController@getAdvertisementApp')->middleware('cors');
Route::get('api/get-cms', 'ApiController@getCMS')->middleware('cors');
Route::post('api/update-user-profile', 'ApiController@updateUserProfile')->middleware('cors');
Route::post('api/update-user-address', 'ApiController@updateUserAddress')->middleware('cors');
Route::post('api/get-user-details', 'ApiController@getUserDetails')->middleware('cors');
Route::post('api/change-password', 'ApiController@changePassword')->middleware('cors');
Route::post('api/get-dashboard', 'ApiController@getDashboard')->middleware('cors');
Route::post('api/edit-ad', 'ApiController@editAd')->middleware('cors');
Route::get('api/get-vendor-ad-details/{ad_id?}', 'ApiController@getVendorAdDetail')->middleware('cors');
Route::post('api/delete-vendor-ad', 'ApiController@deleteVendorAd')->middleware('cors');
Route::get('api/get-customer-ad/{customer_id}/{user_type}', 'ApiController@getCustomerAd')->middleware('cors');
Route::post('api/get-customer-ad-details', 'ApiController@getCustomerAdDetail')->middleware('cors');
Route::post('api/add-vendor-provider', 'ApiController@addVendorProvider')->middleware('cors');
//Route::get('api/get-ad-unit', 'ApiController@getAdUnit')->middleware('cors');
Route::get('api/get-states', 'ApiController@getStates')->middleware('cors');
Route::get('api/get-ticker', 'ApiController@getTicker')->middleware('cors');
Route::post('api/contact-us', 'ApiController@contactUs')->middleware('cors');
Route::post('api/change-ad-status', 'ApiController@changeAdStatus')->middleware('cors');
Route::post('api/delete-ad-image', 'ApiController@deleteAdImage')->middleware('cors');


Route::post('api/save-review', 'ApiController@saveReview')->middleware('cors');
Route::post('api/post-report', 'ApiController@postReport')->middleware('cors');
Route::get('api/show-review', 'ApiController@getReviews')->middleware('cors');

Route::post('api/save-ad-without-login', 'ApiController@saveAdWithoutLogin')->middleware('cors');
Route::post('api/match-otp-post-ad', 'ApiController@matchOtp')->middleware('cors');


Route::post('api/resend-otp', 'ApiController@resendOtp')->middleware('cors');

Route::get('api/site-info', 'ApiController@siteInfo')->middleware('cors');



















Route::resource('advertisementClients', 'advertisementClientsController');

Route::resource('advertisements', 'advertisementController');