<?php

namespace App\Providers;

use App\Settings\SettingSingleton;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
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


    public function boot()
    {
        Paginator::useBootstrap();
      
//        Model::preventLazyLoading(! app()->isProduction());

      

    }
}