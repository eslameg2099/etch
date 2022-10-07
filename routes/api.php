<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('get/address', function (Request $request) {
    return getAddress($request->lng , $request->lat);
});

Route::middleware(['auth:sanctum'])->namespace('Api')->group(function() {
    Route::post('changeMyPhoneNumber', 'Auth\LoginController@changeMyPhoneNumber');
    Route::post('verifyMobileNumber', 'Auth\LoginController@verifyMobileNumber');
    Route::get('resendVerificationCode', 'Auth\LoginController@resendSmsVerificationCode');
    Route::post('changePassword', 'Auth\LoginController@changePassword');
    Route::post('changeMobileNumber', 'Auth\LoginController@changeMobileNumber');
    Route::get('getPusherNotificationToken', 'Auth\LoginController@getPusherNotificationToken');

    Route::get('orders/{order_id}', 'Users\Orders\OrdersController@show');
    Route::get('orders', 'Delegates\OrdersController@index');
    Route::post('orders/{order}/report', 'Users\Orders\OrdersController@report')->name('orders.report');

    Route::post('chats/getMessages', 'Chats\ChatsController@getMessages');
    Route::post('chats/sendMessage', 'Chats\ChatsController@sendMessage');

    Route::post('complaints', 'Chats\ChatsController@complaints');


    Route::get('profile', 'Auth\LoginController@profile');
    Route::get('logout', 'Auth\LoginController@logout');

    Route::post('checkout/prepare', 'WalletController@prepareCheckout')->name('checkout.prepare');
    Route::post('balance/recharge', 'WalletController@recharge')->name('wallet.recharge');
    Route::post('balance/withdrawal', 'WalletController@withdrawal')->name('wallet.withdrawal');
    Route::get('transactions', 'WalletController@transactions')->name('wallet.transactions');
});

Route::namespace('Api')->group(function() {
    Route::get('home', 'ShopsController@home');
    Route::post('bla', 'ShopsController@bla');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('sendResetPasswordCode', 'Auth\LoginController@sendResetPasswordCode');
    Route::get('cities', 'MasterData\CitiesController@index');
    Route::post('checkPhoneIsExists','Auth\LoginController@checkPhoneIsExists')->middleware("throttle:5,20");
    Route::post('resetPassword', 'Auth\LoginController@resetPassword');
    Route::post('contactUs' , 'ContactUsController@store')->middleware("throttle:3,5");
    Route::get('pagesAndContacts', 'SettingsController@pagesAndContacts');
    Route::get('settings', 'SettingsController@index');
    Route::get('settings/ad', 'SettingsController@ad');
    Route::post('checkResetPasswordCode', 'Auth\LoginController@checkResetPasswordCode')->middleware("throttle:5,20");

    Route::resource('categories', 'MasterData\CategoriesController')->except('store', 'update', 'destroy');
    Route::get('categoryShops/{id}', 'MasterData\CategoriesController@categoryShops');

    Route::get('shops', 'ShopsController@index');
    Route::get('shops/{id}', 'ShopsController@show');
    Route::post('shops/{shop}/favorite', 'ShopsController@favorite')->middleware('auth:sanctum');
    Route::post('shops/{shop}/rates', 'ShopsController@rate')->middleware('auth:sanctum');
    Route::get('shops/{shop}/rates', 'ShopsController@rates');
    Route::get('delegates/{user}/rates', 'RateController@delegate')->middleware('auth:sanctum');
    Route::get('notifications/count', 'NotificationController@count');
    Route::get('notifications', 'NotificationController@index')->middleware('auth:sanctum');

//
//    Route::get('getVendorsByLatAndLong', 'AddressesController@getVendorsByLatAndLong');
//    Route::get('ourContacts', 'SettingsAttributesController@ourContacts');
//    Route::get('aboutUs', 'SettingsAttributesController@aboutUs');
//    Route::get('usagePolicy', 'SettingsAttributesController@usagePolicy');
//    Route::get('termsAndConditions', 'SettingsAttributesController@termsAndConditions');

//    Route::apiResource('products', 'ProductsController');
});
Route::get('checkout/status/{payment_type}/{id}', function ($paymentType, $id) {
    return \App\Support\Payment\Facades\Cashier::getResultCode($paymentType, $id);
});
