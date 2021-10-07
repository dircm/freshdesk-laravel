<?php

namespace Mpclarkson\Laravel\Freshdesk;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class FreshdeskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $source = dirname(__DIR__).'/src/config/freshdesk.php';

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('freshdesk.php')]);
        }

        $this->mergeConfigFrom($source, 'freshdesk');

        $this->app->singleton('freshdesk', function ($app) {
            $config = $app->make('config')->get('freshdesk');
            return new Api($config['api_key'], $config['domain']);
        });
        $this->app->alias('freshdesk', Api::class);
    }
}
