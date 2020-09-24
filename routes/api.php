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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});


Route::patch('driver/{id}', 'DriverController@statusUpdate');
Route::get('/driver/search', 'DriverController@search');
Route::get('/driver/blocked', 'DriverController@blocked');
Route::get('/driver/active', 'DriverController@activeDrivers');
Route::get('/driver/all-active', 'DriverController@AllActiveDrivers');

Route::patch('restaurant/{id}', 'RestaurantController@statusUpdate');
Route::get('/restaurant/search', 'RestaurantController@search');
Route::get('/restaurant/blocked', 'RestaurantController@blocked');
Route::get('/restaurant/all', 'RestaurantController@getAll');
Route::get('/restaurant/active', 'RestaurantController@activeRestaurants');
Route::get('/restaurant/all-active', 'RestaurantController@allActiveRestaurants');

Route::get('/promo/search', 'PromoController@search');

Route::patch('sub-admin/{id}', 'SubAdminController@statusUpdate');
Route::get('/sub-admin/search', 'SubAdminController@search');
Route::get('/sub-admin/blocked', 'SubAdminController@blocked');

Route::post('/report/driver-notification', 'ReportController@SMSNotification');
Route::post('/report/driver-mail', 'ReportController@mailNotification');
Route::post('/report/restaurant-notification', 'ReportController@SMSNotification');
Route::post('/report/restaurant-mail', 'ReportController@mailNotification');

Route::post('/restaurant-config/{id}', 'ConfigController@storeConfig');
Route::get('/restaurant-config/{id}', 'ConfigController@show');

Route::get('/restaurant-menu/search/{id}', 'MenuController@searchMenu');
Route::get('/restaurant-menu/{id}', 'MenuController@menus');
Route::post('/restaurant-menu/create/{id}', 'MenuController@createMenu');
Route::delete('/restaurant-menu/delete/{id}', 'MenuController@destroy');

Route::post('/setting/write-up', 'SettingController@createWriteUp');
Route::get('/setting/write-up/{id}', 'SettingController@showWriteUp');

Route::apiResources([
	'driver' => 'DriverController',
	'restaurant' => 'RestaurantController',
	'promo' => 'PromoController',
	'sub-admin' => 'SubAdminController',
]);

