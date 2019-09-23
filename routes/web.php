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

    // User Management
    Route::prefix('users')->group(function () {
        // Agents
        Route::post('agents/{agent}/reset_password', 'Admin\Users\AgentController@resetPassword')->name('admin.agents.reset_password');
        Route::post('agents/{agent}/restore', 'Admin\Users\AgentController@restore')->name('admin.agents.restore');
        Route::resource('agents', 'Admin\Users\AgentController', ['as' => 'admin'])->except(['show']);
        
        // Users
        Route::post('users/{user}/reset_password', 'Admin\Users\UserController@resetPassword')->name('admin.users.reset_password');
        Route::post('users/{user}/restore', 'Admin\Users\UserController@restore')->name('admin.users.restore');
        Route::resource('users', 'Admin\Users\UserController', ['as' => 'admin'])->except(['show']);
    });
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
