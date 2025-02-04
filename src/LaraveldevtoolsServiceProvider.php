<?php

namespace Laraveldevtools\Laraveldevtools;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Laraveldevtools\Laraveldevtools\Components\Database as DatabaseComponent;
use Laraveldevtools\Laraveldevtools\Components\Tables;
use Laraveldevtools\Laraveldevtools\Components\Main;

class LaraveldevtoolsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laraveldevtools');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        Livewire::component('laraveldevtools-database', DatabaseComponent::class);
        Livewire::component('laraveldevtools-tables', Tables::class);
        Livewire::component('laraveldevtools-main', Main::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laraveldevtools/database.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../public/build' => public_path('vendor/laraveldevtools'),
            ], 'assets');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'database');

        // Register the main class to use with the facade
        $this->app->singleton('database', function () {
            return new Database;
        });
    }
}
