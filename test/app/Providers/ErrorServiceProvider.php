<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ErrorServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['errorhandler'] = $this->app->share(function ($app) {
            return new App\Classes\ErrorHandler;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('ErrorHandler', 'App\Classes\ErrorHandler');
        });
    }
}
