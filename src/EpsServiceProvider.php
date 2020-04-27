<?php

namespace Mycools\Eps;

use Illuminate\Support\ServiceProvider;

class EpsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mycools');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'eps');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        if (\App::environment(['local', 'staging'])) {
            $this->loadRoutesFrom(__DIR__.'/routes/demo.php');
        }
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/eps.php', 'eps');

        // Register the service the package provides.
        $this->app->singleton('eps', function ($app) {
            return new ElementPay;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['eps'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/eps.php' => config_path('eps.php'),
        ], 'eps.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/mycools'),
        ], 'eps.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/mycools'),
        ], 'eps.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/mycools'),
        ], 'eps.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
