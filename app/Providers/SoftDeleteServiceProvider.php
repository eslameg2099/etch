<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Models\MasterData\Category;
use App\Models\MasterData\City;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Users\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SoftDeleteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Route::bind('trashed_city', function ($value) {
            return City::onlyTrashed()->where('id', $value)->firstOrFail();
        });
        Route::bind('trashed_user', function ($value) {
            return User::onlyTrashed()->where('type', User::User)->where('id', $value)->firstOrFail();
        });
        Route::bind('trashed_delegate', function ($value) {
            return User::onlyTrashed()->where('type', User::Delegate)->where('id', $value)->firstOrFail();
        });
        Route::bind('trashed_category', function ($value) {
            return Category::onlyTrashed()->where('id', $value)->firstOrFail();
        });
        Route::bind('trashed_shop', function ($value) {
            return Shop::onlyTrashed()->where('id', $value)->firstOrFail();
        });
        Route::bind('trashed_order', function ($value) {
            return Order::onlyTrashed()->where('id', $value)->firstOrFail();
        });
        Route::bind('trashed_coupon', function ($value) {
            return Coupon::onlyTrashed()->where('id', $value)->firstOrFail();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
