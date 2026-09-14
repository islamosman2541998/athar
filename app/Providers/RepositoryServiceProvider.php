<?php

namespace App\Providers;

use App\Repository\DBCartRepository;
use App\Repository\DBTestCartRepository;
use App\RepositoryInterface\CartRepositoryInterface;
use App\RepositoryInterface\TestCartRepositoryInterface;
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
         $this->app->bind(CartRepositoryInterface::class, DBCartRepository::class);
        $this->app->bind(TestCartRepositoryInterface::class, DBTestCartRepository::class);


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
