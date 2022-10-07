<?php

namespace App\Providers;

use App\Models\Chat\OrderChatDetail;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class PolymorphicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'shops'             =>  Shop::class,
            'orderChatDetail'   =>  OrderChatDetail::class,
        ]);
    }
}
