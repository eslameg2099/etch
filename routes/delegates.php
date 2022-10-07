<?php

use App\Http\Requests\Users\StoreDelegateLastLocationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:users', 'cancellation.attempts'])->group(function () {
    Route::resource('user', 'UsersController')->except('store', 'update');
    Route::match(['put', 'patch'],'user', 'UsersController@update');

    Route::post('delegateLastLocation', 'UsersController@lastLocation')->middleware("throttle:15,1");

    Route::post('acceptOrder', 'OrdersController@acceptOrder');
    Route::get('newOrders' , 'OrdersController@newOrders');
    Route::post('withdrawalFromOrder' , 'OrdersController@withdrawalFromOrder');
    Route::post('invoice' , 'OrdersController@invoice');
    Route::post('updateOrderStatus', 'OrdersController@updateOrderStatus');
    Route::match(['PUT', 'PATCH'], 'receive-cash-orders', 'UsersController@receiveCashOrders');
    Route::match(['PUT', 'PATCH'], 'available', 'UsersController@toggleAvailable');
});

Route::middleware('guest:users')->group(function () {
    Route::post('user', 'UsersController@store');
});
