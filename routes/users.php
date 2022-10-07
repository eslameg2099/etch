<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:users', 'cancellation.attempts'])->group(function () {

    Route::resource('user', 'UsersController')->except('store');

    Route::resource('addresses', 'AddressesController')->except('update');

    Route::post('addresses/update', 'AddressesController@update');

    Route::resource('orders', 'Orders\OrdersController');
    Route::get('order/delivered', 'Orders\OrdersController@indexDelivered');
    Route::get('order/purchased', 'Orders\OrdersController@indexPurchased');
    Route::get('order/delivery_cost', 'Orders\OrdersController@deliveryCost');

    Route::patch('orders/{order}/start', 'Orders\OrdersController@start');

    Route::post('acceptOffer', 'Orders\OrdersController@acceptOffer');

    Route::get('orderDetails/{id}', 'Orders\OrdersController@orderDetails');

    Route::post('changeDelegate', 'Orders\OrdersController@changeDelegate');

    Route::post('payForOrder', 'Orders\OrdersController@payForOrder');

    Route::post('getDelegateLastLocation', 'Orders\OrdersController@getDelegateLastLocation');

    Route::post('orders/{order}/rates', 'Orders\OrdersController@rate');

    Route::post('orders/{order}/cancel', 'Orders\OrdersController@cancel');
    Route::post('orders/{order}/coupon', 'Orders\OrdersController@applyCoupon');

    Route::get('favorites', 'UsersController@favorites');

});

//Route::get('interiorAd','Dashboard\AdminNotificationController@ad');

Route::middleware('guest:users')->group(function () {
    Route::post('user', 'UsersController@store');
});
