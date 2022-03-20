<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where youhgcan register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(); //-- この行を追加
Route::prefix('login')->name('login.')->group(function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('{provider}.callback');
});
Route::prefix('register')->name('register.')->group(function () {
    Route::get('/{provider}', 'Auth\RegisterController@showProviderUserRegistrationForm')->name('{provider}');
    Route::post('/{provider}', 'Auth\RegisterController@registerProviderUser')->name('{provider}');    
});
Route::get('/level/{level}', 'WordController@level')->name('words.level');
Route::get('/', 'WordController@index')->name('index');
Route::resource('/words', 'WordController')->except(['index'])->middleware('auth');
Route::resource('/words', 'WordController')->only(['show']);

Route::get('/tags/{name}', 'TagController@show')->name('tags.show');
Route::get('/kanjis/{name}', 'KanjiController@show')->name('kanjis.show');
Route::get('/search', 'WordController@search')->name('words.search');

Route::get('/choose', 'WordController@choose')->name('choose');
Route::post('/import', 'WordController@import')->name('import');
Route::post('/clear', 'WordController@clear')->name('clear');
Route::post('/trim', 'WordController@trim')->name('trim');
Route::get('/learn', 'LearnController@learn')->name('learn');

Route::get('/learn/random', 'LearnController@getWords')->name('learn.random');
Route::post('/learn/record', 'LearnController@store')->name('learn.record');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{name}', 'UserController@show')->name('show');
    
});