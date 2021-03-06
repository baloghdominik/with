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



Route::get('/login', 'LoginController@index')->name('login');

Route::get('/add-meal', 'MealController@addMeal');
Route::get('/add-side', 'SideController@addSide');
Route::get('/add-drink', 'DrinkController@addDrink');

Route::get('/list-meal', 'MealController@listMeal');
Route::get('/list-side', 'SideController@listSide');
Route::get('/list-drink', 'DrinkController@listDrink');

Route::get('/edit-meal/{id}', 'MealController@editMeal');
Route::get('/edit-side/{id}', 'SideController@editSide');
Route::get('/edit-drink/{id}', 'DrinkController@editDrink');

Route::post('/delete-drink', 'DrinkController@deleteDrink');
Route::post('/delete-meal', 'MealController@deleteMeal');
Route::post('/delete-side', 'SideController@deleteSide');

Route::get('/category-settings', 'CategoryController@listCategory');
Route::post('/add-category', 'CategoryController@addCategory');
Route::post('/delete-category', 'CategoryController@deleteCategory');

Route::get('/settings', 'RestaurantController@showSettings');
Route::post('/update-settings', 'RestaurantController@updateSettings');
Route::post('/upload-images', 'RestaurantController@uploadImages');

Route::get('/help', 'HelpController@showHelp');
Route::get('/videorepo', 'HelpController@showVideoRepository');
Route::get('/updates', 'HelpController@showUpdates');

Route::get('/user-settings', 'RestaurantController@showUserSettings');
Route::post('/change-password', 'UserSettingsController@changePassword');

Route::get('/pizzadesigner-size', 'PizzadesignerController@showSize');
Route::post('/pizzadesigner-add-size', 'PizzadesignerController@addSize');
Route::post('/pizzadesigner-remove-size', 'PizzadesignerController@removeSize');

Route::get('/pizzadesigner-base', 'PizzadesignerController@showBase');
Route::post('/pizzadesigner-add-base', 'PizzadesignerController@addBase');
Route::post('/pizzadesigner-remove-base', 'PizzadesignerController@removeBase');

Route::get('/pizzadesigner-topping', 'PizzadesignerController@showTopping');
Route::post('/pizzadesigner-add-topping', 'PizzadesignerController@addTopping');
Route::post('/pizzadesigner-remove-topping', 'PizzadesignerController@removeTopping');

Route::get('/pizzadesigner-sauce', 'PizzadesignerController@showSauce');
Route::post('/pizzadesigner-add-sauce', 'PizzadesignerController@addSauce');
Route::post('/pizzadesigner-remove-sauce', 'PizzadesignerController@removeSauce');

Route::get('/pizzadesigner-dough', 'PizzadesignerController@showDough');
Route::post('/pizzadesigner-add-dough', 'PizzadesignerController@addDough');
Route::post('/pizzadesigner-remove-dough', 'PizzadesignerController@removeDough');

Route::get('/edit-menu/{id}', 'MenuController@editMenu');
Route::post('/update-menu', 'MenuController@updateMenu');

Route::post('/add-side-to-menu', 'MenuController@addSideToMenu');
Route::post('/remove-side-from-menu', 'MenuController@removeSidefromMeal');

Route::post('/add-drink-to-menu', 'MenuController@addDrinkToMenu');
Route::post('/remove-drink-from-menu', 'MenuController@removeDrinkfromMenu');

Route::post('/update-meal/{id}', 'MealController@updateMeal');
Route::post('/update-side/{id}', 'SideController@updateSide');
Route::post('/update-drink/{id}', 'DrinkController@updateDrink');

Route::post('/add-side', 'SideController@insertSide');
Route::post('/add-drink', 'DrinkController@insertDrink');
Route::post('/add-meal', 'MealController@insertMeal');

Route::post('/add-extra', 'MealController@addExtra');
Route::post('/remove-extra', 'MealController@removeExtra');

Route::get('/reservations', 'ReservationController@showReservations');
Route::post('/update-reservation', 'ReservationController@updateReservation');
Route::post('/delete-reservation', 'ReservationController@deleteReservation');

Route::get('/orders', 'OrderController@showOrders');
Route::get('/accept-order/{id}', 'OrderController@acceptOrder');
Route::post('/accept-pickup-order', 'OrderController@acceptPickupOrder');
Route::get('/done-order/{id}', 'OrderController@doneOrder');
Route::get('/outfordelivery-order/{id}', 'OrderController@outForDeliveryOrder');
Route::get('/delivered-order/{id}', 'OrderController@deliveredOrder');
Route::get('/finished-order/{id}', 'OrderController@finishedOrder');
Route::get('/startrefund-order/{id}', 'OrderController@startRefundOrder');
Route::get('/finishrefund-order/{id}', 'OrderController@finishRefundOrder');
Route::get('/cancel-order/{id}', 'OrderController@cancelOrder');

// Route Components
Route::get('/sk-layout-2-columns', 'StaterkitController@columns_2');
Route::get('/sk-layout-fixed-navbar', 'StaterkitController@fixed_navbar');
Route::get('/sk-layout-floating-navbar', 'StaterkitController@floating_navbar');
Route::get('/sk-layout-fixed', 'StaterkitController@fixed_layout');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/mail', 'HomeController@mail');
Route::get('/mail2', 'HomeController@mail2');
Route::get('/testdl', 'HomeController@testdl');
