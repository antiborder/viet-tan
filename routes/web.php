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
Route::get('/', 'WordController@index')->name('words.index');
Route::resource('/words', 'WordController')->except(['index'])->middleware('auth');
Route::resource('/words', 'WordController')->only(['show']);

Route::get('/tags/{name}', 'TagController@show')->name('tags.show');
Route::get('/kanjis/{name}', 'KanjiController@show')->name('kanjis.show');
Route::get('/search', 'WordController@search')->name('words.search');

Route::get('/choose', 'WordController@choose')->name('choose');
Route::post('/import', 'WordController@import')->name('import');
Route::get('/learn', 'WordController@learn')->name('words.learn');

Route::get('/learn/random', 'WordController@random')->name('words.random');