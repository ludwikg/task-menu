<?php

namespace App\Providers;

use App\Item;
use App\Menu;
use App\Repositories\ItemCacheDecoratorRepository;
use App\Repositories\ItemEloquentRepository;
use App\Repositories\ItemRepositoryInterface;
use App\Repositories\MenuCacheDecoratorRepository;
use App\Repositories\MenuEloquentRepository;
use App\Repositories\MenuRepositoryInterface;
use App\Services\ItemChildrenService;
use App\Services\ItemService;
use App\Services\MenuDepthService;
use App\Services\MenuItemService;
use App\Services\MenuLayerService;
use App\Services\MenuService;
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
        $cacheEnabled = $this->app['config']['cache.enabled'];

        if ($cacheEnabled) {

            $this->app->when(ItemService::class)
                ->needs(ItemRepositoryInterface::class)
                ->give(ItemCacheDecoratorRepository::class);

            $this->app->when(MenuLayerService::class)
                ->needs(ItemRepositoryInterface::class)
                ->give(ItemCacheDecoratorRepository::class);

            $this->app->when(ItemChildrenService::class)
                ->needs(ItemRepositoryInterface::class)
                ->give(ItemCacheDecoratorRepository::class);

            $this->app->when(MenuDepthService::class)
                ->needs(ItemRepositoryInterface::class)
                ->give(ItemCacheDecoratorRepository::class);

            $this->app->when(MenuItemService::class)
                ->needs(ItemRepositoryInterface::class)
                ->give(ItemCacheDecoratorRepository::class);

            $this->app->when(ItemCacheDecoratorRepository::class)
                ->needs(ItemRepositoryInterface::class)
                ->give(ItemEloquentRepository::class);


            $this->app->when(MenuItemService::class)
                ->needs(MenuRepositoryInterface::class)
                ->give(MenuCacheDecoratorRepository::class);

            $this->app->when(MenuService::class)
                ->needs(MenuRepositoryInterface::class)
                ->give(MenuCacheDecoratorRepository::class);

            $this->app->when(MenuCacheDecoratorRepository::class)
                ->needs(MenuRepositoryInterface::class)
                ->give(MenuEloquentRepository::class);

        } else {
            $this->app->bind(ItemRepositoryInterface::class, function ($app) {
                return new ItemEloquentRepository(new Item());
            });

            $this->app->bind(MenuRepositoryInterface::class, function ($app) {
                return new MenuEloquentRepository(new Menu());
            });
        }
    }
}
