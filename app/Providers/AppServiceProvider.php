<?php

namespace Square\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Square\Repositories\Contracts\SquareRepositoryInterface;
use Square\Repositories\SquareRepository;
use Square\Repositories\TerritoryRepository;
use Square\Services\Contracts\SquareServiceInterface;
use Square\Services\Contracts\TerritoryServiceInterface;
use Square\Services\SquareService;
use Square\Services\TerritoryService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(120);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            TerritoryServiceInterface::class,
            TerritoryRepository::class
        );

        $this->app->bind(
            TerritoryServiceInterface::class,
            TerritoryService::class
        );

        $this->app->bind(
            SquareRepositoryInterface::class,
            SquareRepository::class
        );

        $this->app->bind(
            SquareServiceInterface::class,
            SquareService::class
        );
    }
}
