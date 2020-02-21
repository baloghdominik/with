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

Route::get('/settings', 'SettingsController@showSettings');
Route::post('/update-settings', 'SettingsController@updateSettings');
Route::post('/upload-images', 'SettingsController@uploadImages');


Route::get('/edit-menu/{id}', 'MenuController@editMenu');
Route::post('/add-side-to-menu', 'MenuController@addSideToMeal');
Route::post('/remove-side-from-menu', 'MenuController@removeSidefromMeal');

Route::post('/add-drink-to-menu', 'MenuController@addDrinkToMeal');
Route::post('/remove-drink-from-menu', 'MenuController@removeDrinkfromMeal');

Route::post('/update-meal/{id}', 'MealController@updateMeal');
Route::post('/update-side/{id}', 'SideController@updateSide');
Route::post('/update-drink/{id}', 'DrinkController@updateDrink');

Route::post('/add-side', 'SideController@insertSide');
Route::post('/add-drink', 'DrinkController@insertDrink');
Route::post('/add-meal', 'MealController@insertMeal');

// Route Components
Route::get('/sk-layout-2-columns', 'StaterkitController@columns_2');
Route::get('/sk-layout-fixed-navbar', 'StaterkitController@fixed_navbar');
Route::get('/sk-layout-floating-navbar', 'StaterkitController@floating_navbar');
Route::get('/sk-layout-fixed', 'StaterkitController@fixed_layout');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
