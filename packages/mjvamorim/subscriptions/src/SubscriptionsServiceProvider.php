<?php

namespace Amorim\Subscriptions;

use Illuminate\Support\ServiceProvider;


class SubscriptionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //Views
        $this->loadViewsFrom(__DIR__.'/views', 'subscriptions'); //return view(subscription::index”);
        $this->publishes([__DIR__.'/views' => resource_path('views/mjvamorim/subscriptions'),]);
        

        //Migrations
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->publishes([__DIR__.'/migrations' => database_path('migrations'),]);


        //Assets
        //$this->publishes([__DIR__.'/resources/js' => public_path('mjvamorim/subscriptions/js'),], 'public');
        //$this->publishes([__DIR__.'/resources/js' => public_path('mjvamorim/subscriptions/js'),], 'public');
    }

    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('Amorim\Subscriptions\Controllers\SubscriptionsController');
    }

}
