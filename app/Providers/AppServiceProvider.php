<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_ALL, env('APP_LOCALE', 'id'));
        Carbon::setLocale(env('APP_LOCALE', 'id'));
        Schema::defaultStringLength(191); //191
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
