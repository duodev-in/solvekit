<?php

namespace App\Providers;

use App\View\Components\Ads;
use App\View\Components\AppLayout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceHttps($this->app->isProduction());

        Blade::component('app-layout', AppLayout::class);
        Blade::component('ads', Ads::class);
    }
}
