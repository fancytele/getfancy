<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('two-factor-code','Auth\LoginController@generateTwoFactorCode')->name('admin.login.send_two_factor_code');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
