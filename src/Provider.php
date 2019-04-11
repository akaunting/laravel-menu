<?php

namespace Akaunting\Menu;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $configPath = __DIR__ . '/Config/menu.php';
        $viewsPath = __DIR__ . '/Resources/views';
        
        $this->mergeConfigFrom($configPath, 'menu');
        $this->loadViewsFrom($viewsPath, 'menu');

        $this->publishes([
            $configPath => config_path('menu.php'),
        ], 'menu');

        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/akaunting/menu'),
        ], 'views');
        
        if (file_exists($file = app_path('Support/menu.php'))) {
            require $file;
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerHtmlPackage();

        $this->app->singleton('menu', function ($app) {
            return new Menu($app['view'], $app['config']);
        });
    }

    /**
     * Register "iluminate/html" package.
     */
    private function registerHtmlPackage()
    {
        $this->app->register('Collective\Html\HtmlServiceProvider');

        $aliases = [
            'HTML' => 'Collective\Html\HtmlFacade',
            'Form' => 'Collective\Html\FormFacade',
        ];

        AliasLoader::getInstance($aliases)->register();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['menu'];
    }
}
