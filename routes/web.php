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
Route::get('/category','TagController@category')->name('tags.category');

Route::get('/kanjis/{name}', 'KanjiController@show')->name('kanjis.show');
Route::get('/search', 'WordController@search')->name('words.search');

Route::get('/choose', 'WordController@choose')->name('choose');
Route::post('/import', 'WordController@import')->name('import');
Route::post('/clear', 'WordController@clear')->name('clear');
Route::post('/trim', 'WordController@trim')->name('trim');
Route::get('/export_words', 'WordController@export_words')->name('export_words');
Route::get('/export_tags', 'WordController@export_tags')->name('export_tags');

Route::get('/learn', 'LearnController@learn')->name('learn');
Route::get('/learn/random', 'LearnController@getWords')->name('learn.random');
Route::post('/learn/record', 'LearnController@store')->name('learn.record');
Route::get('/learn/{level}', 'LearnController@learn')->name('learn.level');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{name}', 'UserController@show')->name('show');
    
});

//stripe
Route::get('/subscription', 'StripeController@subscription')->name('stripe.subscription');
Route::post('/subscription/afterpay', 'StripeController@afterpay')->name('stripe.afterpay');
Route::post('/subscription/cancel/{user}', 'StripeController@cancelsubscription')->name('stripe.cancel');
Route::get('/subscription/portal/{user}', 'StripeController@portalsubscription')->name('stripe.portalsubscription');
Route::post('stripe/webhook', 'WebhookController@handleWebhook');

//Contact
Route::get('/contact', 'ContactController@index')->name('contact.index');
Route::post('/contact/confirm', 'ContactController@confirm')->name('contact.confirm');
Route::post('/contact/thanks', 'ContactController@send')->name('contact.send');

//tag

