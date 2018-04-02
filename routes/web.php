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

Route::get('/', 'Vue\VueHomeController@index')->name('home');
Route::get('/home', 'Vue\VueHomeController@index')->name('vue.home');

Route::get('/aboutme', function () {
    return view('about-me');
})->name('AboutMe');;

//Auth::routes();


//Route::group([ 'prefix' => 'module', 'as' => 'module.'], function () {
//    Route::get('todolist', 'TodoListController@index')->name('todolist.index');
//    Route::get('oauth', 'OAuthSettingController@index')->name('oauth.setting');
//});


//Route::get('/vue', function () {
//    return view('vue.welcome');
//})->name('VueWelcome');;
