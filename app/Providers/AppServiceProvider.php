<?php

namespace App\Providers;

use App\Item;
use App\Menu;
use App\Repositories\ItemEloquentRepository;
use App\Repositories\ItemRepositoryInterface;
use App\Repositories\MenuEloquentRepository;
use App\Repositories\MenuRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(MenuRepositoryInterface::class, function ($app) {
            return new MenuEloquentRepository(new Menu());
        });
        $this->app->bind(ItemRepositoryInterface::class, function ($app) {
            return new ItemEloquentRepository(new Item());
        });


    }
}
