<?php

namespace App\Providers;

use App\Interfaces\CategoriesRepositoryInterface;
use App\Interfaces\CitiesRepositoryInterface;
use App\Interfaces\ContactUsRepositoryInterface;
use App\Interfaces\OrdersRepositoryInterface;
use App\Interfaces\ShopsRepositoryInterface;
use App\Interfaces\UserAddressesRepositoryInterface;
use App\Interfaces\UsersRepositoryInterface;
use App\Repositories\AddressesRepositories;
use App\Repositories\CategoriesRepository;
use App\Repositories\CitiesRepository;
use App\Repositories\ContactUsRepositories;
use App\Repositories\OrdersRepository;
use App\Repositories\ShopsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UsersRepositoryInterface::class,
            UsersRepository::class
        );

        $this->app->bind(
            CitiesRepositoryInterface::class,
            CitiesRepository::class
        );

        $this->app->bind(
            UserAddressesRepositoryInterface::class,
            AddressesRepositories::class
        );

        $this->app->bind(
            ContactUsRepositoryInterface::class,
            ContactUsRepositories::class
        );

        $this->app->bind(
            OrdersRepositoryInterface::class,
            OrdersRepository::class
        );

        $this->app->bind(
            CategoriesRepositoryInterface::class,
            CategoriesRepository::class
        );

        $this->app->bind(
            ShopsRepositoryInterface::class,
            ShopsRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
