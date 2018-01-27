<?php

namespace Josh\Components\Navigation\Provider;

use Josh\Components\Navigation\Navigation;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class NavigationServiceProvider extends BaseServiceProvider
{
    /**
     * Boot the package in application
     *
     * @retrun void
     * @param Navigation $navigation
     */
    public function boot(Navigation $navigation)
    {
        $this->app->bind('navbar', function() use($navigation){

            return $navigation;
        });

        if(file_exists($file = base_path('routes/navigation.php'))){
            
            $this->map($file);
        }
    }

    /**
     * Register config files
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/../routes.php' => base_path('routes/navigation.php'),
            __DIR__ . '/../view.blade.php' => resource_path('views/navbar.blade.php'),
        ]);
    }

    /**
     * Load config files
     *
     * @param $file
     */
    public function map($file)
    {
        if(file_exists($file)){

            $this->app['navbar']->loadFile($file);
        }
    }
}
