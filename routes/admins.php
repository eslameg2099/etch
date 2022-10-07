<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admins'])->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('changeLang', 'HomeController@changeLang')->name('changeLang');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('trashed/cities', 'CityController@trashed')->name('cities.trashed');
    Route::get('trashed/cities/{trashed_city}', 'CityController@show')->name('cities.trashed.show');
    Route::get('cities/{trashed_city}/restore', 'CityController@restore')->name('cities.restore');
    Route::resource('cities', 'CityController');

    Route::resource('admins', 'AdminController');

    Route::get('trashed/users', 'UserController@trashed')->name('users.trashed');
    Route::get('trashed/users/{trashed_user}', 'UserController@show')->name('users.trashed.show');
    Route::get('users/{trashed_user}/restore', 'UserController@restore')->name('users.restore');
    Route::get('user/export', 'UserController@export')->name('user.export');
    Route::resource('users', 'UserController');

    Route::get('trashed/delegates', 'DelegateController@trashed')->name('delegates.trashed');
    Route::get('trashed/delegates/{trashed_delegate}', 'DelegateController@show')->name('delegates.trashed.show');
    Route::get('delegates/{trashed_delegate}/restore', 'DelegateController@restore')->name('delegates.restore');
    Route::get('delegate/export', 'DelegateController@export')->name('delegate.export');
    Route::resource('delegates', 'DelegateController');

    Route::get('trashed/categories', 'CategoryController@trashed')->name('categories.trashed');
    Route::get('trashed/categories/{trashed_category}', 'CategoryController@show')->name('categories.trashed.show');
    Route::get('categories/{trashed_category}/restore', 'CategoryController@restore')->name('categories.restore');
    Route::resource('categories', 'CategoryController');

    Route::get('trashed/memberships', 'MembershipController@trashed')->name('memberships.trashed');
    Route::get('trashed/memberships/{trashed_membership}', 'MembershipController@show')->name('memberships.trashed.show');
    Route::get('memberships/{trashed_membership}/restore', 'MembershipController@restore')->name('memberships.restore');
    Route::resource('memberships', 'MembershipController');


    Route::get('trashed/shops', 'ShopController@trashed')->name('shops.trashed');
    Route::get('trashed/shops/{trashed_shop}', 'ShopController@show')->name('shops.trashed.show');
    Route::get('shops/{trashed_shop}/restore', 'ShopController@restore')->name('shops.restore');
    Route::resource('shops', 'ShopController');

    Route::resource('branches','BranchController');
    Route::get('branch/Shop/{shop}','BranchController@createBranchShop')->name('branches.createBranchShop');
    Route::post('branch/Shop/store/{shop}','BranchController@storeBranchShop')->name('branches.storeBranchShop');
    Route::get('branches/{trashed_branch}/restore', 'BranchController@restore')->name('branches.restore');

    Route::get('trashed/coupons', 'CouponController@trashed')->name('coupons.trashed');
    Route::get('trashed/coupons/{trashed_coupon}', 'CouponController@show')->name('coupons.trashed.show');
    Route::get('coupons/{trashed_coupon}/restore', 'CouponController@restore')->name('coupons.restore');
    Route::resource('coupons', 'CouponController');

    Route::resource('reports', 'ReportController');
    Route::get('audits','AuditController@index')->name("audits.index");
    Route::resource('contact_us', 'ContactUsController');

    Route::get('trashed/orders', 'OrderController@trashed')->name('orders.trashed');
    Route::get('trashed/orders/{trashed_order}', 'OrderController@show')->name('orders.trashed.show');
    Route::get('orders/{trashed_order}/restore', 'OrderController@restore')->name('orders.restore');
    Route::get('orders/{order}/edit', 'OrderController@edit')->name('orders.edit');
    Route::put('orders/{order}/update', 'OrderController@update')->name('orders.update');
    Route::resource('orders', 'OrderController')->only('index', 'show', 'destroy');

    Route::get('system/wallet', 'WalletController@system')->name('wallets.system');
    Route::get('wallet/delegates', 'WalletController@delegates')->name('wallets.delegates');
    Route::get('wallet/users', 'WalletController@users')->name('wallets.users');
    Route::get('wallet/{user}', 'WalletController@show')->name('wallets.show');
    Route::get('withdrawal/requests', 'WalletController@withdrawal')->name('withdrawal.requests');
    Route::get('withdrawal/export', 'WalletController@export')->name('withdrawal.export');
    Route::get('withdrawal/{transaction}/confirm', 'WalletController@withdrawalConfirm')->name('withdrawal.confirm');
    Route::post('users/{user}/wallet/recharge', 'WalletController@recharge')->name('wallets.recharge');

    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::get('backup/download', 'SettingController@downloadBackup')->name('backup.download');
    Route::patch('settings', 'SettingController@update')->name('settings.update');
    Route::get('collects', 'CollectController@index')->name('collects.index');
    Route::get('collects/{user}', 'CollectController@show')->name('collects.show');
    Route::patch('collects/{user}', 'CollectController@collect')->name('collects.collect');

    Route::resource('notifications','NotificationController');
    Route::resource('adminNotifications','AdminNotificationController');
    Route::put('adminNotifications/active/{adminNotification}','AdminNotificationController@active')->name('adminNotifications.active');
});

Route::middleware(['guest'])->group(function() {
    Route::get('login' , 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login' , 'Auth\LoginController@login')->name('login');
});
