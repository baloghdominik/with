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

// Route Dashboards
Route::get('/dashboard-analytics', 'DashboardController@dashboardAnalytics');

Route::get('/add-meal', 'MealController@addMeal');
Route::get('/add-side', 'SideController@addSide');
Route::get('/add-drink', 'DrinkController@addDrink');
Route::post('/add-side', 'SideController@insertSide');

// Route Components
Route::get('/sk-layout-2-columns', 'StaterkitController@columns_2');
Route::get('/sk-layout-fixed-navbar', 'StaterkitController@fixed_navbar');
Route::get('/sk-layout-floating-navbar', 'StaterkitController@floating_navbar');
Route::get('/sk-layout-fixed', 'StaterkitController@fixed_layout');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
