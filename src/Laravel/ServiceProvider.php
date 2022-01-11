<?php

namespace ZerosDev\Prismalink\Laravel;

use ZerosDev\Prismalink\Client;
use ZerosDev\Prismalink\Constant;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return new Client(
                config('prismalink.mode'),
                config('prismalink.merchant_id'),
                config('prismalink.key_id'),
                config('prismalink.secret_key'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../laravel-config.php' => config_path('prismalink.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class];
    }
}
