<?php

namespace Amorim\Upload;

use Illuminate\Support\ServiceProvider;


class UploadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //Views
        $this->loadViewsFrom(__DIR__.'/views', 'upload'); //return view(upload::index”);
        $this->publishes([__DIR__.'/views' => resource_path('views/mjvamorim/upload'),],'views');
        

        //Migrations
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations/'),],'migrations');
        
        //Seeds
        //$this->publishes([__DIR__.'/database/seeds' => database_path('seeds/'),],'seeds');

        //Config
        //$this->publishes([__DIR__.'/config/upload.php' => config_path('upload.php'), ],'config');

        //Assets
        $this->publishes([__DIR__.'/assets/js' => public_path('/js'),], 'assets');
        $this->publishes([__DIR__.'/assets/css' => public_path('/css'),], 'assets');
    }

    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('Amorim\Upload\Controllers\UploadController');
    }

}
