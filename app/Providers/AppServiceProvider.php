<?php

namespace App\Providers;

use App\View\Forms\Components\TimeComponent;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laraeast\LaravelBootstrapForms\Facades\BsForm;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);

        $this->app->register(SoftDeleteServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        BsForm::registerComponent('color', TimeComponent::class);

        Paginator::useBootstrap();

        $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
            return $paginator->appends(
                Arr::except(
                    request()->query(),
                    $paginator->getPageName()
                )
            );
        });
    }
}
