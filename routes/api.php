<?php

use Illuminate\Http\Request;

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

Route::post('login', 'CustomerController@login');
Route::post('register', 'CustomerController@register');

Route::get('notification/{id}', 'NotificationController@update');
Route::get('/', 'NotificationController@getinfo');

Route::get('restaurants/near/zip/{zipcode}', 'RestaurantAPIController@getAllRestaurantsNearByZipcode');
Route::get('restaurants/near/geo/{latitude}/{longitude}', 'RestaurantAPIController@getAllRestaurantsNearByGEO');

Route::get('restaurant/alldata/{id}', 'RestaurantAPIController@getRestaurantAlldataById');
Route::get('restaurant/logo/{id}', 'RestaurantAPIController@getRestaurantLogoById');
Route::get('restaurant/lowercasename/{lowercasename}', 'RestaurantAPIController@getRestaurantIdBylowercasename');

Route::get('restaurant/{id}/products/category/{categoryid}', 'RestaurantAPIController@getRestaurantProductsByCategory');
Route::get('restaurant/{id}/products/pizzadesigner', 'RestaurantAPIController@getRestaurantPizzaDesigner');

Route::get('restaurant/id/{id}', 'RestaurantAPIController@getRestaurantById');
Route::get('restaurants', 'RestaurantAPIController@getAllRestaurants');
Route::get('restaurantids', 'RestaurantAPIController@getAllRestaurantIds');

Route::get('mail', 'MailerController@newMail');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'CustomerController@details');
    Route::post('logout', 'CustomerController@logout');

    Route::get('customer/details', 'CustomerController@getCustomerDetails');
    Route::post('customer/update/details', 'CustomerController@updateCustomerDetails');
    Route::post('customer/update/password', 'CustomerController@updateCustomerPassword');
    Route::get('customer/orders/{status}', 'CustomerController@getCustomerOrders'); // inprogress / completed

    Route::post('reservate', 'ReservationAPIController@addReservation');
    Route::post('addorder', 'OrderAPIController@addOrder');
});