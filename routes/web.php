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

Route::group(['middleware'=>['web']], function()
{
	Route::resource('blog','BlogController');
	Route::post('/blog/editItem','BlogController@editItem')->name('editItem');
	Route::post('/blog/addItem','BlogController@addItem')->name('addItem');
	Route::post('/blog/deleteItem','BlogController@deleteItem')->name('deleteItem');
});