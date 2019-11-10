<?php

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
|
| Website views and actions
|
*/

Route::get('/', 'WebSiteController@index')->name('web.homepage');
Route::get('/{locale}', 'WebSiteController@changeLocalization')->name('web.locale');
Route::get('checkout/{slug}', 'WebSiteController@checkout')->name('web.checkout');
Route::post('callyou', 'WebSiteController@callYou')->name('web.callyou');
Route::post('contactus', 'WebSiteController@contactUs')->name('web.contactus');
Route::get('js/lang.js', 'WebSiteController@getJSONLocalization')->name('web.lang');
Route::post('subscription', 'SubscriptionController@create')->name('subscription');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Administration views and actions
|
*/
Route::prefix('admin')->group(function () {
    // Auth
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login.show')->middleware('guest');
    Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    // Dashboard
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    // Users Management
    Route::post('users/{user}/reset_password', 'Admin\Users\UserController@resetPassword')->name('admin.users.reset_password');
    Route::post('users/{user}/restore', 'Admin\Users\UserController@restore')->name('admin.users.restore');
    Route::get('users/{user}/edit/fancy', 'Admin\Users\UserController@editFancy')->name('admin.users.edit_fancy');
    Route::put('users/{user}/update/fancy', 'Admin\Users\UserController@updateFancy')->name('admin.users.update_fancy');
    Route::resource('users', 'Admin\Users\UserController', ['as' => 'admin'])->except(['show']);

    // Agents Management
    Route::post('agents/{agent}/reset_password', 'Admin\Users\AgentController@resetPassword')->name('admin.agents.reset_password');
    Route::post('agents/{agent}/restore', 'Admin\Users\AgentController@restore')->name('admin.agents.restore');
    Route::resource('agents', 'Admin\Users\AgentController', ['as' => 'admin'])->except(['show']);

    // Operators Management
    Route::post('operators/{operator}/reset_password', 'Admin\Users\OperatorController@resetPassword')->name('admin.operators.reset_password');
    Route::post('operators/{operator}/restore', 'Admin\Users\OperatorController@restore')->name('admin.operators.restore');
    Route::resource('operators', 'Admin\Users\OperatorController', ['as' => 'admin'])->except(['show']);

    Route::resource('tickets', 'Admin\TicketController', ['as' => 'admin']);

    // DID
    Route::get('dids/regions/{region}/cities', 'Admin\DIDController@getCitiesByRegion')->name('admin.dids.cities');
    Route::get('dids/cities/{city}/availables', 'Admin\DIDController@getAvailableDIDsByCity')->name('admin.dids.availables');
    Route::post('dids/reserve', 'Admin\DIDController@storeReservation')->name('admin.dids.create_reservation');
    Route::delete('dids/reserve/{did}', 'Admin\DIDController@destroyReservation')->name('admin.dids.destroy_reservation');
});


/*
|--------------------------------------------------------------------------
| Emails Routes
|--------------------------------------------------------------------------
|
| Email views and actions
|
*/
Route::prefix('emails')->group(function () {
    Route::get('receipts/{receipt_id}', 'EmailController@receiptSubscription')->name('mail.receipt');
});


/*
|--------------------------------------------------------------------------
| Others Routes
|--------------------------------------------------------------------------
|
|
*/
Route::stripeWebhooks('stripe/webhook');
