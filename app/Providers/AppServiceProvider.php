<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Channel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // $channels = Channel::latest()->paginate();
        // view()->share('channels', $channels);

        \View::composer('*', function($view) {
            $channles = \Cache::rememberForever('channels', function(){
                return Channel::latest()->paginate();
            });
            // var_dump('doing it'); this view composer runs twice so we put channels in cache, but view share can be used which only runs once.
            $view->with('channels', $channles);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->isLocal()){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
