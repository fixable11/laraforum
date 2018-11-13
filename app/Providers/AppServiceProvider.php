<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Channel;
use Illuminate\Support\Facades\Validator;
use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            '*', function($view){
                $channels = Cache::rememberForever('channels', function(){
                    return Channel::all();
                });
                $view->with('categories', Category::all());
                $view->with('channels', Channel::all());
            }
        );

        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
