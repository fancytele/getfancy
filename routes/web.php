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

Route::get('/', 'WebSiteController@index')->name('web.homepage');
Route::get('checkout/{slug}', 'WebSiteController@checkout')->name('web.checkout');
Route::post('locale', 'WebSiteController@changeLocalization')->name('web.locale');
Route::post('callyou', 'WebsiteController@callYou')->name('web.callyou');
Route::get('js/lang.js', 'WebSiteController@getJSONLocalization')->name('web.lang');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('subscription', 'SubscriptionController@create')->name('subscription');

Route::prefix('emails')->group(function () {
    Route::get('receipts/{receipt_id}', 'EmailController@receiptSubscription')->name('mail.receipt');
});

Route::stripeWebhooks('stripe/webhook');
