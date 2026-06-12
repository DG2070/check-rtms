<?php

namespace App\Providers;

use Akaunting\Money\Money;
use Akaunting\Money\Currency;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        ini_set("memory_limit","2586M");
        //-- Enforce https
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        // Blade money directive
        // Blade::directive('money', function ($amount, $currency = "NPR") {
        //     $money =  new Money($amount, new Currency($currency));
        //     return $money;
        // });
    }
}
