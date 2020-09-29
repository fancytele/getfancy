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
Route::get('pages/privacy-policy', 'WebSiteController@getPrivacyPolicy')->name('web.privacy_policy');
Route::get('pages/terms-of-service', 'WebSiteController@getTermsOfService')->name('web.terms_of_service');
Route::get('pages/cookie-policy', 'WebSiteController@getCookiePolicy')->name('web.cookie_policy');
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
    Route::post('login', 'Auth\LoginController@authenticated')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::get('create/account/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    // Impersonate user
    Route::get('roles/{role}/users', 'Admin\Users\UserController@usersByRole')->middleware(['role:admin|user'])->name('admin.roles.users');
    Route::get('users/{id}/impersonate', 'Admin\Users\UserController@impersonate')->name('admin.users.impersonate');
    Route::get('users/stop', 'Admin\Users\UserController@stopImpersonate')->name('admin.users.stop_impersonate');


    Route::middleware(['impersonate'])->group(function () {
        // Dashboard
        Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

        // Users Management
        Route::post('users/{user}/reset_password', 'Admin\Users\UserController@resetPassword')->name('admin.users.reset_password');
        Route::get('users/create/fancy', 'Admin\Users\UserController@createFancy')->name('admin.users.create_fancy');
        Route::post('users/store/fancy', 'Admin\Users\UserController@storeFancy')->name('admin.users.store_fancy');
        Route::get('users/{user}/edit/fancy', 'Admin\Users\UserController@editFancy')->name('admin.users.edit_fancy');
        Route::post('users/{user}/update/fancy', 'Admin\Users\UserController@updateFancy')->name('admin.users.update_fancy');
        Route::resource('users', 'Admin\Users\UserController', ['as' => 'admin'])->except(['show', 'edit', 'destroy']);
        // Milestone 2 - user profile settings
        Route::get('users/{user}/edit/profile', 'Admin\Users\UserController@editProfile')->name('admin.users.edit_profile');
        Route::post('users/{user}/update/profile', 'Admin\Users\UserController@updateProfile')->name('admin.users.update_profile');
        Route::post('users/{user}/cancel/subscription' , 'Admin\Users\UserController@cancelSubscription')->name('admin.users.cancel_subscription');
        Route::get('users/{user}/payment_methods' , 'Admin\Users\UserController@getAllPaymentMethods')->name('admin.users.get_all_payment_methods');
        Route::post('users/{user}/update/default_card','Admin\Users\UserController@updateDefaultCard')->name('admin.users.update_default_card');
        Route::delete('users/{user}/delete/payment_methods' , 'Admin\Users\UserController@deletePaymentMethod')->name('admin.users.delete_payment_methods');
        Route::post('users/{user}/update/two_factor_authentication' , 'Admin\Users\UserController@updateTwoFactorAuthentication')->name('admin.users.update_two_factor_authentication');
        Route::post('users/{user}/add/authorized_user','Admin\Users\UserController@addAuthorizedUser')->name('admin.users.add_authorized_user');
        Route::post('users/{user}/delete/authorized_user','Admin\Users\UserController@deleteAuthorizedUser')->name('admin.users.delete_authorized_user');
        Route::get('users/{user}/authorized_user','Admin\Users\UserController@getAuthorizedUser')->name('admin.users.get_authorized_user');


        // Agents Management
        Route::post('agents/{agent}/reset_password', 'Admin\Users\AgentController@resetPassword')->name('admin.agents.reset_password');
        Route::post('agents/{agent}/restore', 'Admin\Users\AgentController@restore')->name('admin.agents.restore');
        Route::resource('agents', 'Admin\Users\AgentController', ['as' => 'admin'])->except(['show']);

        // Operators Management
        Route::post('operators/{operator}/reset_password', 'Admin\Users\OperatorController@resetPassword')->name('admin.operators.reset_password');
        Route::post('operators/{operator}/restore', 'Admin\Users\OperatorController@restore')->name('admin.operators.restore');
        Route::resource('operators', 'Admin\Users\OperatorController', ['as' => 'admin'])->except(['show']);

        Route::post('tickets/{ticket}/open', 'Admin\TicketController@openTicket')->name('admin.tickets.open');
        Route::resource('tickets', 'Admin\TicketController', ['as' => 'admin'])->except(['create', 'store']);

        // DID
        Route::get('dids/regions/{region}/cities', 'Admin\DIDController@getCitiesByRegion')->name('admin.dids.cities');
        Route::get('dids/cities/{city}/availables', 'Admin\DIDController@getAvailableDIDsByCity')->name('admin.dids.availables');
        Route::post('dids/reserve', 'Admin\DIDController@storeReservation')->name('admin.dids.create_reservation');
        Route::delete('dids/reserve/{did}', 'Admin\DIDController@destroyReservation')->name('admin.dids.destroy_reservation');
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
