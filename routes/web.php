<?php

use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Pusher\Pusher;
use Pusher\PushNotifications\PushNotifications;

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

Route::get('shop', 'ShopController@index')->name('shop.index');
Route::post('shop', 'ShopController@store')->name('shop.store');
Route::get('delegates', 'DelegateController@index')->name('delegate.get.register');
Route::post('delegates', 'DelegateController@store')->name('delegate.register');
Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/home', '/');
Route::redirect('/login', '/');

//Route::get('api', function () {
//    return redirect()->away('https://documenter.getpostman.com/view/11612700/TVsxBmbM');
//});

Route::get('sms/{mobile?}', function ($mobile = null) {
    $log = \App\Models\MasterData\SmsLog::query()->latest();
    if ($mobile) {
        $log->whereHas('user', function ($q) use ($mobile) {
            $q->where('mobile', $mobile);
        });
    }

    return $log->get()->map(function ($log) {
        return [
            'mobile' => optional($log->user)->mobile,
            'code' => $log->code,
            'message' => $log->message,
            'created_at' => $log->created_at,
        ];
    });
});

Route::get('testEvents', function () {
    $receivingAddress = \App\Models\Users\Address::query()->find(1);
    $query = User::query()
        ->ClosestDelegates($receivingAddress->lat, $receivingAddress->lng, $receivingAddress->city_id);
    dd($query->toSql(), $query->getBindings(), $query->get(), $receivingAddress, Carbon::now(),
        Carbon::now()->subHour());

    event(new \App\Events\NewOrderEvent(\App\Models\Orders\Order::query()->find(1)));
    dd('done');
});

Route::get('fakeShops', function () {
    $user = User::query()->whereDoesntHave('delegateOrders', function ($query) {
        return $query->whereNull('closed_at');
    });

    $shop = \App\Models\Shop::query()->create([
        'ar_name' => 'ست الشام',
        'category_id' => 2,
        'city_is' => 1,
        'rank' => '3.4',
        'lat' => '31.25',
        'long' => '29.99',
        'open_at' => '09:00:00',
        'closed_at' => '23:00:00',
    ]);
    $shop->images()->create(['path' => 'image.png']);
});

Route::get('channels', function () {
    $pusher = new Pusher('98d66d631fb3ac28b54b', 'b8e9a1808c3c71bcb6c2', '1130040', ['cluster' => 'eu']);
    $response = $pusher->get('/channels/presence-socket-status/users');
    $users = [];
    if ($response && $response['status'] == 200) {
        dd($response);
        $users = array_map(function ($user) {
            return $user->id;
        }, json_decode($response['body'])->users);
    }
    dd($users);
});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('pusher/auth', 'Auth\LoginController@getPusherChannelToken');

Route::get('test/beams', function () {
    User::first()->notify(new \App\Notifications\Orders\NewOrderNotification('test'));
});

Route::get('/test/payment', function () {
    $order = \App\Models\Orders\Order::first();
    dd($order->getTaxCostForApp());

    Cashier::bill();
});