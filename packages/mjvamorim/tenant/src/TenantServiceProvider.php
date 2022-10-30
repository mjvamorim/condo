<?php

namespace Amorim\Tenant;

use Illuminate\Support\ServiceProvider;


class TenantServiceProvider extends ServiceProvider {
    public function boot()
    {
        //$this->loadRoutesFrom(__DIR__.'/routes.php');

        //Views
        //$this->loadViewsFrom(__DIR__.'/views', 'tenant'); //return view(tenant::model);
        //$this->publishes([__DIR__.'/views' => resource_path('views/mjvamorim/tenant'),],'views');
        

        //Migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations/'),],'migrations');


        //Config & Models
        $this->publishes([__DIR__.'/config/tenant.php' => config_path('tenant.php'),],'config');
        $this->publishes([__DIR__.'/Models/User.php' => app_path('User.php'),],'models');
      

        //Assets
        //$this->publishes([__DIR__.'/resources/js' => public_path('mjvamorim/tenant/js'),], 'public');

    }

    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('Amorim\Tenant\Controllers\EmpresaController');

    }
}