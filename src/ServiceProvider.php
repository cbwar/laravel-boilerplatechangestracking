<?php

namespace Cbwar\Laravel\BoilerplateTracks;

use Illuminate\Support\ServiceProvider as Provider;
use Illuminate\Foundation\AliasLoader;

class ServiceProvider extends Provider
{
    /**
     * Service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->loader = AliasLoader::getInstance();
        $this->router = app('router');
        parent::__construct($app);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // If routes file has been published, load routes from the published file
        if (is_file(base_path('routes/boilerplate_tracks.php'))) {
            $this->loadRoutesFrom(base_path('routes/boilerplate_tracks.php'));
        } else {
            $this->loadRoutesFrom(__DIR__ . '/routes/boilerplate_tracks.php');
        }

        // Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'boilerplate_tracks');

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        // Translations
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'boilerplate_tracks');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/menu.php', 'boilerplate.menu.providers');

        config([
            'boilerplate.app.prefix' => config('boilerplate.app.prefix') === '' ? 'admin' : config('boilerplate.app.prefix')
        ]);

        $this->app->register(\Cbwar\Laravel\ModelTracking\ServiceProvider::class);
    }
}
